<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\ClassSession;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Data DEMO portal training: 15 murid + 5 kelas (dengan lokasi & periode),
 * 4–6 pertemuan per kelas, absensi & nilai realistis.
 *
 * Idempotent: murid/kelas dicari berdasarkan nama — tidak menduplikasi.
 * Tidak menimpa data guru (akun demo guru dipastikan ada via PortalUsersSeeder).
 */
class TrainingDemoSeeder extends Seeder
{
    public function run(): void
    {
        $teacher1 = User::where('email', 'guru@iflanguage.com')->first();
        $admin = User::where('role', User::ROLE_ADMIN)->first();

        // ===== 15 MURID (dengan ID WeChat) =====
        $students = [
            ['Budi Santoso', '628111000001', 'budi_wx88'],
            ['Siti Rahma', '628111000002', 'siti_rhm'],
            ['Li Wei', '628111000003', 'liwei_cn'],
            ['Chen Jing', '628111000004', 'chenjing_wx'],
            ['Andi Pratama', '628111000005', 'andiprtm'],
            ['Dewi Lestari', '628111000006', 'dewilst'],
            ['Wang Fang', '628111000007', 'wangfang7'],
            ['Rina Marlina', '628111000008', 'rina_ml'],
            ['Zhang Yu', '628111000009', 'zhangyu88'],
            ['Fajar Nugroho', '628111000010', 'fajarng'],
            ['Maya Sari', '628111000011', 'maya_sari'],
            ['Liu Ming', '628111000012', 'liuming77'],
            ['Rudi Hartono', '628111000013', 'rudihrt'],
            ['Indah Permata', '628111000014', 'indahprm'],
            ['Sun Lei', '628111000015', 'sunlei_wx'],
        ];

        $studentIds = [];
        foreach ($students as [$name, $phone, $wechat]) {
            $studentIds[] = Student::updateOrCreate(
                ['name' => $name],
                ['phone' => $phone, 'wechat_id' => $wechat, 'is_active' => true]
            )->id;
        }

        // ===== 5 KELAS (lokasi + periode) =====
        $classes = [
            ['Mandarin Pemula A', 2, $teacher1?->id ?? $admin?->id, 'Ruang 101', '2026-09-01', '2026-12-15', [0, 1, 2, 3, 4, 5, 6, 7]],
            ['Mandarin Menengah B', 2, $teacher1?->id ?? $admin?->id, 'Ruang 302', '2026-08-20', '2026-11-30', [2, 3, 8, 9, 10, 11]],
            ['English Conversation', 1, $admin?->id, 'Online', '2026-09-10', '2026-12-20', [4, 5, 12, 13, 14]],
            ['Indonesia untuk WNA', 3, $admin?->id, 'Ruang 202', '2026-07-15', '2026-10-30', [2, 3, 6, 8, 11, 14]],
            ['HSK 3 Preparation', 2, $teacher1?->id ?? $admin?->id, 'Ruang 303', '2026-09-05', '2026-01-28', [0, 2, 4, 6, 8, 10, 12, 14]],
        ];

        foreach ($classes as [$name, $courseId, $teacherId, $location, $start, $end, $memberIdx]) {
            $class = SchoolClass::updateOrCreate(
                ['name' => $name],
                [
                    'course_id' => $courseId,
                    'teacher_id' => $teacherId,
                    'location' => $location,
                    'started_at' => $start,
                    'ended_at' => $end,
                    'status' => 'active',
                ]
            );

            $class->students()->sync(array_map(fn ($i) => $studentIds[$i], $memberIdx));

            $this->seedSessions($class, $memberIdx, $start);
        }

        $this->command->info('✅ Data demo portal: 15 murid + 5 kelas + sesi/absensi/nilai');
    }

    /** Buat 4–6 pertemuan per kelas + absensi + nilai (idempotent via unique constraint). */
    protected function seedSessions(SchoolClass $class, array $memberIdx, string $startDate): void
    {
        $studentIds = array_map(fn ($i) => Student::orderBy('id')->skip($i)->first()->id, $memberIdx);

        $sessionCount = random_int(4, 6);

        for ($seq = 1; $seq <= $sessionCount; $seq++) {
            $session = ClassSession::updateOrCreate(
                ['school_class_id' => $class->id, 'sequence' => $seq],
                [
                    'session_date' => \Carbon\Carbon::parse($startDate)->addWeeks($seq - 1),
                    'material' => $this->materialFor($seq),
                ]
            );

            foreach ($studentIds as $studentId) {
                // 82% hadir, 8% izin/sakit, 10% alpa (deterministik per kombinasi)
                $seed = crc32($class->id . '-' . $session->id . '-' . $studentId) % 100;
                $status = match (true) {
                    $seed < 82 => Attendance::STATUS_PRESENT,
                    $seed < 90 => $seed % 2 === 0 ? Attendance::STATUS_EXCUSED : Attendance::STATUS_SICK,
                    default => Attendance::STATUS_ABSENT,
                };

                Attendance::updateOrCreate(
                    ['class_session_id' => $session->id, 'student_id' => $studentId],
                    ['status' => $status, 'marked_by' => $class->teacher_id]
                );
            }
        }

        // Nilai: quiz (bobot 1) + ujian (bobot 2) per murid
        foreach ($studentIds as $studentId) {
            $seed = crc32($class->id . '-g-' . $studentId);

            Grade::updateOrCreate(
                [
                    'school_class_id' => $class->id,
                    'student_id' => $studentId,
                    'type' => 'quiz',
                    'title' => 'Kuis Pertengahan',
                ],
                [
                    'score' => 60 + $seed % 40,
                    'weight' => 1,
                    'graded_at' => \Carbon\Carbon::parse($startDate)->addWeeks(2),
                    'created_by' => $class->teacher_id,
                ]
            );

            Grade::updateOrCreate(
                [
                    'school_class_id' => $class->id,
                    'student_id' => $studentId,
                    'type' => 'exam',
                    'title' => 'Ujian Akhir',
                ],
                [
                    'score' => 55 + ($seed >> 3) % 45,
                    'weight' => 2,
                    'graded_at' => \Carbon\Carbon::parse($startDate)->addWeeks(4),
                    'created_by' => $class->teacher_id,
                ]
            );
        }
    }

    protected function materialFor(int $seq): string
    {
        return match ($seq) {
            1 => 'Pengenalan & perkenalan diri',
            2 => 'Kosakata dasar + latihan dialog',
            3 => 'Tata bahasa: struktur kalimat',
            4 => 'Latihan mendengar (listening)',
            5 => 'Presentasi & role-play',
            default => 'Review & evaluasi',
        };
    }
}
