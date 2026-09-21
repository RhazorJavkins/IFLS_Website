<?php

namespace App\Models;

use App\Support\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name', 'name_cn', 'role', 'bio', 'photo', 'quote',
        'is_director', 'show_on_home', 'sort', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'role' => 'array',
            'bio' => 'array',
            'is_director' => 'boolean',
            'show_on_home' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    // Accessor i18n (dipakai view): terjemah otomatis per locale
    protected function translatedRole(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('role'));
    }

    protected function translatedBio(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('bio'));
    }

    // URL foto: "images/..." = file legacy di public/, selain itu = upload CMS di storage/public
    public function getPhotoUrlAttribute(): string
    {
        return str_starts_with($this->photo, 'images/')
            ? asset($this->photo)
            : asset('storage/'.$this->photo);
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }
}
