<?php

namespace App\Models;

use App\Support\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'content', 'sort', 'is_active'];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'content' => 'array',
            'is_active' => 'boolean',
        ];
    }

    // Accessor i18n (dipakai view): $testimonial->translated_name terjemah otomatis per locale
    protected function translatedName(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('name'));
    }

    protected function translatedContent(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('content'));
    }
}
