<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    protected $fillable = [
        'name', 'course_id', 'teacher_id', 'started_at', 'ended_at', 'status',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'date',
            'ended_at' => 'date',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'class_student');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(ClassSession::class)->orderByDesc('session_date');
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    /** Persentase kehadiran murid di kelas ini (semua sesi tercatat). */
    public function attendanceRate(int $studentId): ?float
    {
        $total = Attendance::whereIn('class_session_id', $this->sessions()->pluck('id'))
            ->where('student_id', $studentId)
            ->count();

        if ($total === 0) {
            return null;
        }

        $present = Attendance::whereIn('class_session_id', $this->sessions()->pluck('id'))
            ->where('student_id', $studentId)
            ->whereIn('status', ['present', 'excused', 'sick'])
            ->count();

        return round($present / $total * 100, 1);
    }

    /** Jumlah alpa murid di kelas ini. */
    public function absences(int $studentId): int
    {
        return Attendance::whereIn('class_session_id', $this->sessions()->pluck('id'))
            ->where('student_id', $studentId)
            ->where('status', 'absent')
            ->count();
    }

    /** Rata-rata nilai tertimbang murid di kelas ini (skala 0–100). */
    public function weightedAverage(int $studentId): ?float
    {
        $grades = $this->grades()->where('student_id', $studentId)->get(['score', 'weight']);

        if ($grades->isEmpty()) {
            return null;
        }

        $weightSum = (float) $grades->sum('weight');

        if ($weightSum === 0.0) {
            return round((float) $grades->avg('score'), 1);
        }

        $weighted = $grades->reduce(fn ($carry, $g) => $carry + ((float) $g->score * (float) $g->weight), 0.0);

        return round($weighted / $weightSum, 1);
    }

    /** Murid berisiko: alpa ≥ 3 ATAU rata-rata nilai < 70 (yang punya nilai). */
    public function atRiskStudents(): array
    {
        $risk = [];

        foreach ($this->students as $student) {
            $absences = $this->absences($student->id);
            $avg = $this->weightedAverage($student->id);

            if ($absences >= 3 || (is_numeric($avg) && $avg < 70)) {
                $risk[] = [
                    'student' => $student,
                    'absences' => $absences,
                    'average' => $avg,
                ];
            }
        }

        return $risk;
    }
}
