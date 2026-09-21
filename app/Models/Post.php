<?php

namespace App\Models;

use App\Support\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasTranslations;

    protected $fillable = ['slug', 'title', 'excerpt', 'body', 'cover_image', 'is_published', 'published_at'];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'excerpt' => 'array',
            'body' => 'array',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    protected function translatedTitle(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('title'));
    }

    protected function translatedExcerpt(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('excerpt'));
    }

    protected function translatedBody(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('body'));
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->whereNotNull('published_at');
    }

    // Ambil body sebagai daftar paragraf (dipisah baris kosong)
    public function paragraphs(): array
    {
        $raw = (string) $this->tr('body');

        return array_values(array_filter(array_map('trim', preg_split('/\n\s*\n/', $raw))));
    }
}
