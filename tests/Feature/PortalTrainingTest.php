<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\ClassSession;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortalTrainingTest extends TestCase
{
    use RefreshDatabase;

    private User $teacher;

    private User $otherTeacher;

    private SchoolClass $class;

    private Student $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teacher = User::create([
            'name' => 'Guru Satu', 'email' => 'guru1@example.test',
            'password' => 'password-rahasia-12', 'role' => User::ROLE_TEACHER,
        ]);
        $this->otherTeacher = User::create([
            'name' => 'Guru Dua', 'email' => 'guru2@example.test',
            'password' => 'password-rahasia-12', 'role' => User::ROLE_TEACHER,
        ]);

        $this->class = SchoolClass::create([
            'name' => 'Mandarin Pemula A',
            'teacher_id' => $this->teacher->id,
            'status' => 'active',
        ]);

        $this->student = Student::create(['name' => 'Budi', 'phone' => '628123456789']);
        $this->class->students()->attach($this->student->id);
    }

    /** Guru hanya melihat kelas miliknya. */
    public function test_teacher_only_sees_own_class(): void
    {
        SchoolClass::create(['name' => 'Kelas Guru Lain', 'teacher_id' => $this->otherTeacher->id]);

        $this->actingAs($this->teacher)->get('/training/classes')->assertOk();

        // Akses langsung ke kelas orang lain → 404 (query di-scope)
        $otherClass = SchoolClass::where('teacher_id', $this->otherTeacher->id)->first();
        $this->actingAs($this->teacher)->get("/training/classes/{$otherClass->id}")->assertNotFound();
    }

    /** Absensi: constraint unik menolak duplikat; UI memakai updateOrCreate (upsert). */
    public function test_attendance_is_unique_per_session_and_student(): void
    {
        $session = ClassSession::create([
            'school_class_id' => $this->class->id,
            'sequence' => 1,
            'session_date' => now(),
        ]);

        Attendance::create(['class_session_id' => $session->id, 'student_id' => $this->student->id, 'status' => 'present']);

        // Insert mentah kedua untuk pasangan sama → ditolak DB
        $this->expectException(\Illuminate\Database\UniqueConstraintViolationException::class);
        Attendance::create(['class_session_id' => $session->id, 'student_id' => $this->student->id, 'status' => 'absent']);
    }

    /** Jalur yang dipakai UI: updateOrCreate memperbarui, bukan menduplikasi. */
    public function test_attendance_upsert_updates_instead_of_duplicating(): void
    {
        $session = ClassSession::create(['school_class_id' => $this->class->id, 'sequence' => 1, 'session_date' => now()]);

        Attendance::updateOrCreate(
            ['class_session_id' => $session->id, 'student_id' => $this->student->id],
            ['status' => 'present', 'marked_by' => $this->teacher->id]
        );
        Attendance::updateOrCreate(
            ['class_session_id' => $session->id, 'student_id' => $this->student->id],
            ['status' => 'absent', 'marked_by' => $this->teacher->id]
        );

        $this->assertSame(1, Attendance::where('class_session_id', $session->id)->where('student_id', $this->student->id)->count());
        $this->assertSame('absent', Attendance::where('class_session_id', $session->id)->where('student_id', $this->student->id)->value('status'));
    }

    /** Sesi tidak bisa duplikat urutan dalam satu kelas. */
    public function test_session_sequence_is_unique_per_class(): void
    {
        ClassSession::create(['school_class_id' => $this->class->id, 'sequence' => 1, 'session_date' => now()]);

        $this->expectException(\Illuminate\Database\UniqueConstraintViolationException::class);
        ClassSession::create(['school_class_id' => $this->class->id, 'sequence' => 1, 'session_date' => now()]);
    }

    /** Nilai tertimbang: (80×2 + 60×1) / 3 = 73.3 */
    public function test_weighted_average_calculation(): void
    {
        Grade::create(['school_class_id' => $this->class->id, 'student_id' => $this->student->id, 'type' => 'exam', 'score' => 80, 'weight' => 2]);
        Grade::create(['school_class_id' => $this->class->id, 'student_id' => $this->student->id, 'type' => 'quiz', 'score' => 60, 'weight' => 1]);

        $this->assertSame(73.3, $this->class->weightedAverage($this->student->id));
    }

    /** Persentase kehadiran: hadir+izin+sakit dihitung hadir. */
    public function test_attendance_rate_counts_excused_and_sick_as_present(): void
    {
        $s1 = ClassSession::create(['school_class_id' => $this->class->id, 'sequence' => 1, 'session_date' => now()]);
        $s2 = ClassSession::create(['school_class_id' => $this->class->id, 'sequence' => 2, 'session_date' => now()]);
        $s3 = ClassSession::create(['school_class_id' => $this->class->id, 'sequence' => 3, 'session_date' => now()]);

        Attendance::create(['class_session_id' => $s1->id, 'student_id' => $this->student->id, 'status' => 'present']);
        Attendance::create(['class_session_id' => $s2->id, 'student_id' => $this->student->id, 'status' => 'sick']);
        Attendance::create(['class_session_id' => $s3->id, 'student_id' => $this->student->id, 'status' => 'absent']);

        $this->assertSame(66.7, $this->class->attendanceRate($this->student->id));
        $this->assertSame(1, $this->class->absences($this->student->id));
    }

    /** Murid berisiko: alpa ≥ 3 ATAU rata-rata < 70. */
    public function test_at_risk_students_detection(): void
    {
        // Murid A: 3× alpa → berisiko
        $a = Student::create(['name' => 'Alpa Tiga']);
        $this->class->students()->attach($a->id);

        // Murid B: nilai rendah → berisiko
        $b = Student::create(['name' => 'Nilai Rendah']);
        $this->class->students()->attach($b->id);

        // Murid C: aman
        $c = Student::create(['name' => 'Siswa Rajin']);
        $this->class->students()->attach($c->id);

        for ($i = 1; $i <= 3; $i++) {
            $s = ClassSession::create(['school_class_id' => $this->class->id, 'sequence' => $i, 'session_date' => now()]);
            Attendance::create(['class_session_id' => $s->id, 'student_id' => $a->id, 'status' => 'absent']);
            Attendance::create(['class_session_id' => $s->id, 'student_id' => $b->id, 'status' => 'present']);
            Attendance::create(['class_session_id' => $s->id, 'student_id' => $c->id, 'status' => 'present']);
        }

        Grade::create(['school_class_id' => $this->class->id, 'student_id' => $b->id, 'type' => 'exam', 'score' => 60, 'weight' => 1]);
        Grade::create(['school_class_id' => $this->class->id, 'student_id' => $c->id, 'type' => 'exam', 'score' => 90, 'weight' => 1]);

        $risk = collect($this->class->atRiskStudents())->pluck('student.name')->all();

        $this->assertContains('Alpa Tiga', $risk);
        $this->assertContains('Nilai Rendah', $risk);
        $this->assertNotContains('Siswa Rajin', $risk);
    }

    /** Halaman laporan render dengan data. */
    public function test_class_report_page_renders(): void
    {
        $this->actingAs($this->teacher)->get("/training/classes/{$this->class->id}/report")->assertOk();
        $this->actingAs($this->teacher)->get("/training/classes/{$this->class->id}/attendance")->assertOk();
        $this->actingAs($this->teacher)->get("/training/classes/{$this->class->id}/grades")->assertOk();
    }

    /** Export CSV absensi hanya untuk guru pemilik kelas / admin. */
    public function test_attendance_csv_access_control(): void
    {
        $this->actingAs($this->teacher)
            ->get("/portal/training/{$this->class->id}/absensi.csv")
            ->assertOk()
            ->assertHeader('content-type', 'text/csv; charset=UTF-8');

        // Guru lain → 403 (middleware membersihkan session)
        $this->actingAs($this->otherTeacher)
            ->get("/portal/training/{$this->class->id}/absensi.csv")
            ->assertForbidden();

        auth()->logout();

        // Tamu → redirect login
        $this->get("/portal/training/{$this->class->id}/absensi.csv")->assertRedirect();
    }
}
