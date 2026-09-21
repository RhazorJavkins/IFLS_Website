<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validasi upload gambar yang aman:
 * - cek MIME ASLI file (bukan cuma ekstensi/nama)
 * - batas ukuran (default 3 MB)
 * Pemakaian di form upload CMS: ['required', 'file', new SafeImage()]
 */
class SafeImage implements ValidationRule
{
    public function __construct(
        protected int $maxKilobytes = 3072,
        protected array $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'],
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof \Illuminate\Http\UploadedFile) {
            $fail('File tidak valid.');

            return;
        }

        // MIME asli dari ISI file, bukan dari nama
        $mime = $value->getMimeType();

        if (! in_array($mime, $this->allowedMimes, true)) {
            $fail('Tipe file tidak diizinkan (harus JPG/PNG/WebP/GIF).');

            return;
        }

        if ($value->getSize() > $this->maxKilobytes * 1024) {
            $fail('Ukuran file maksimal ' . round($this->maxKilobytes / 1024, 1) . ' MB.');

            return;
        }

        // PHP/ script yang menyamar sebagai gambar tetap ditolak
        $head = (string) $value->getContent();
        if (str_contains($head, '<?php') || str_contains($head, '<?=')) {
            $fail('Isi file mencurigakan.');
        }
    }
}
