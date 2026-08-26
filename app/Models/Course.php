<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'level', 'price', 'duration', 'max_students', 'is_active'];

    // Cast JSON ke array/object otomatis
    protected $casts = [
        'name' => 'json',
        'description' => 'json',
    ];

    // Relasi: Satu course punya banyak jadwal
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Helper untuk mengambil nama sesuai bahasa aktif
    public function getTranslatedNameAttribute()
    {
        $locale = app()->getLocale();

        // Jika name sudah berupa array/object (hasil cast json), ambil langsung
        if (is_array($this->name) || is_object($this->name)) {
            $data = (array) $this->name;
            return $data[$locale] ?? $data['id'] ?? 'N/A';
        }

        // Jika masih string, coba decode JSON
        if (is_string($this->name)) {
            $data = json_decode($this->name, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $data[$locale] ?? $data['id'] ?? 'N/A';
            }
            return $this->name; // fallback ke string asli
        }

        return 'N/A';
    }

    public function getTranslatedDescriptionAttribute()
    {
        $locale = app()->getLocale();
        
        // Jika description adalah object/array
        if (is_object($this->description) || is_array($this->description)) {
            $data = (array) $this->description;
            return $data[$locale] ?? $data['id'] ?? '';
        }
        
        // Jika description masih string, coba decode JSON
        if (is_string($this->description)) {
            $data = json_decode($this->description, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $data[$locale] ?? $data['id'] ?? '';
            }
            return $this->description; // fallback ke string asli
        }
        
        return '';
    }
}