<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    public const STATUS_PRESENT = 'present';

    public const STATUS_EXCUSED = 'excused';

    public const STATUS_SICK = 'sick';

    public const STATUS_ABSENT = 'absent';

    public const STATUSES = [
        self::STATUS_PRESENT => 'Hadir',
        self::STATUS_EXCUSED => 'Izin',
        self::STATUS_SICK => 'Sakit',
        self::STATUS_ABSENT => 'Alpa',
    ];

    protected $fillable = ['class_session_id', 'student_id', 'status', 'marked_by'];

    public function session(): BelongsTo
    {
        return $this->belongsTo(ClassSession::class, 'class_session_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function marker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'marked_by');
    }
}
