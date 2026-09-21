<?php

namespace App\Models;

use App\Support\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasTranslations;

    protected $fillable = [
        'slug', 'name', 'badge', 'intro', 'emoji', 'color', 'display_style',
        'group_meta', 'is_flagship', 'show_coming_soon', 'cta_text', 'wa_prefill',
        'sort', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'badge' => 'array',
            'intro' => 'array',
            'group_meta' => 'array',
            'cta_text' => 'array',
            'is_flagship' => 'boolean',
            'show_coming_soon' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    protected function translatedName(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('name'));
    }

    protected function translatedBadge(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('badge'));
    }

    protected function translatedIntro(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('intro'));
    }

    protected function translatedCtaText(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::get(fn () => $this->tr('cta_text'));
    }

    public function features(): HasMany
    {
        return $this->hasMany(ProgramFeature::class)->orderBy('sort');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function activeFeatures(): HasMany
    {
        return $this->features()->where('is_active', true);
    }

    // Judul heading untuk satu grup fitur (dari group_meta), fallback ke nama grup
    public function groupTitle(string $group): string
    {
        $meta = $this->group_meta[$group] ?? null;

        return $meta['title'][app()->getLocale()]
            ?? $meta['title']['id']
            ?? ucfirst(str_replace('_', ' ', $group));
    }

    public function groupIcon(string $group): ?string
    {
        return $this->group_meta[$group]['icon'] ?? null;
    }

    // URL WhatsApp program (dengan prefill + nomor dari config)
    public function waLink(): string
    {
        $number = config('services.whatsapp.number', '628118887568');
        $text = $this->wa_prefill ?: 'Halo IF Language School';

        return 'https://wa.me/' . $number . '?text=' . rawurlencode($text);
    }
}
