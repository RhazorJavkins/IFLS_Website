<?php

namespace App\Models;

use App\Support\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use HasTranslations;

    protected $fillable = ['image', 'caption', 'sort', 'is_active'];

    protected function casts(): array
    {
        return [
            'caption' => 'array',
            'is_active' => 'boolean',
        ];
    }

    protected function caption(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn ($v) => $this->tr('caption'));
    }
}
