<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    public const TYPES = [
        'quiz' => 'Kuis',
        'exam' => 'Ujian',
        'assignment' => 'Tugas',
        'practice' => 'Praktik',
    ];

    protected $fillable = [
        'school_class_id', 'student_id', 'type', 'title', 'score', 'weight', 'graded_at', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'weight' => 'decimal:2',
            'graded_at' => 'date',
        ];
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
