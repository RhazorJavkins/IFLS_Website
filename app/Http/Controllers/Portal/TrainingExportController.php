<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Export CSV untuk portal training.
 * Di luar panel Filament agar unduhan bisa jadi link langsung (a href).
 * Keamanan: auth + middleware role + cek kepemilikan kelas untuk guru.
 */
class TrainingExportController extends Controller
{
    public function attendanceCsv(SchoolClass $class): StreamedResponse
    {
        $this->authorizeClass($class);

        return response()->streamDownload(function () use ($class) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM agar Excel membaca dengan benar
            fputcsv($out, ['murid', 'pertemuan', 'tanggal', 'status']);

            Attendance::query()
                ->whereIn('class_session_id', $class->sessions()->pluck('id'))
                ->with(['student:id,name', 'session:id,sequence,session_date'])
                ->orderBy('student_id')
                ->chunk(500, function ($rows) use ($out) {
                    foreach ($rows as $row) {
                        fputcsv($out, [
                            $row->student?->name,
                            'P' . $row->session?->sequence,
                            optional($row->session?->session_date)->format('Y-m-d'),
                            $row->status,
                        ]);
                    }
                });

            fclose($out);
        }, 'absensi-' . Str::slug($class->name) . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function gradesCsv(SchoolClass $class): StreamedResponse
    {
        $this->authorizeClass($class);

        return response()->streamDownload(function () use ($class) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['murid', 'jenis', 'judul', 'skor', 'bobot', 'tanggal']);

            $class->grades()
                ->with('student:id,name')
                ->orderBy('student_id')
                ->chunk(500, function ($rows) use ($out) {
                    foreach ($rows as $g) {
                        fputcsv($out, [
                            $g->student?->name,
                            $g->type,
                            $g->title,
                            $g->score,
                            $g->weight,
                            optional($g->graded_at)->format('Y-m-d'),
                        ]);
                    }
                });

            fclose($out);
        }, 'nilai-' . Str::slug($class->name) . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    protected function authorizeClass(SchoolClass $class): void
    {
        $user = auth()->user();

        if ($user && $user->isTeacher() && $class->teacher_id !== $user->id) {
            abort(403);
        }
    }
}
