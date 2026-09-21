<?php

namespace App\Models;

use App\Support\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use HasTranslations;

    protected $fillable = ['icon', 'name', 'price_note', 'sort', 'is_active'];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'price_note' => 'array',
            'is_active' => 'boolean',
        ];
    }

    protected function translatedName(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('name'));
    }

    protected function translatedPriceNote(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('price_note'));
    }
}
