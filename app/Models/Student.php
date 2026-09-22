<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'wechat_id', 'notes', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'class_student');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }
}
