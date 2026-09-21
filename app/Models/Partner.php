<?php

namespace App\Models;

use App\Support\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'initial', 'color', 'url', 'sort', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
