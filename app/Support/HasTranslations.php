<?php

namespace App\Support;

/**
 * Standarisasi kolom JSON multibahasa: {"id":"...","en":"...","zh":"..."}.
 * Pemakaian di model: buat accessor, mis.
 *   protected function name(): Attribute { return Attribute::get(fn ($v) => $this->tr('name')); }
 * atau panggil langsung $model->tr('name') di controller/view.
 */
trait HasTranslations
{
    public function tr(string $key, ?string $locale = null): ?string
    {
        $locale ??= app()->getLocale();

        $value = $this->getAttribute($key);

        // Bisa jadi sudah di-cast array oleh Eloquent, atau masih string JSON mentah
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            $value = json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
        }

        if (! is_array($value)) {
            return is_string($value) && $value !== '' ? $value : null;
        }

        return $value[$locale] ?? $value['id'] ?? null;
    }
}
