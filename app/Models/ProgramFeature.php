<?php

namespace App\Models;

use App\Support\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramFeature extends Model
{
    use HasTranslations;

    protected $fillable = ['program_id', 'group', 'title', 'description', 'icon', 'badge', 'sort', 'is_active'];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'description' => 'array',
            'is_active' => 'boolean',
        ];
    }

    protected function translatedTitle(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('title'));
    }

    protected function translatedDescription(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('description'));
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
