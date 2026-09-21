<?php

namespace App\Models;

use App\Support\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasTranslations;

    protected $fillable = ['question', 'answer', 'sort', 'is_active'];

    protected function casts(): array
    {
        return [
            'question' => 'array',
            'answer' => 'array',
            'is_active' => 'boolean',
        ];
    }

    protected function translatedQuestion(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('question'));
    }

    protected function translatedAnswer(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('answer'));
    }
}
