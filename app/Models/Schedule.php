<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'type', 'day', 'start_time', 'end_time', 'instructor', 'room', 'quota', 'is_full'];

    // Relasi: Jadwal milik satu course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Helper untuk cek kuota
    public function getQuotaRemainingAttribute()
    {
        // Nanti akan di-update dengan sistem registrasi
        return $this->quota; // Sementara masih full quota
    }
}