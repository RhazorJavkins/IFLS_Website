<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * Dokumen disimpan di disk 'local' (storage/app/private/documents) — TIDAK bisa
 * diakses via URL publik. Unduhan hanya lewat route ter-proteksi auth+role.
 */
class Document extends Model
{
    protected $fillable = [
        'translate_job_id', 'uploaded_by', 'title', 'file_path', 'mime_type', 'size_bytes',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(TranslateJob::class, 'translate_job_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function downloadUrl(): string
    {
        return route('portal.translate.documents.download', $this);
    }

    public function humanSize(): string
    {
        $bytes = (int) $this->size_bytes;

        if ($bytes === 0) {
            return '—';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $i = (int) floor(log($bytes, 1024));

        return round($bytes / (1024 ** $i), 1) . ' ' . ($units[$i] ?? 'B');
    }

    protected static function booted(): void
    {
        // Hapus file fisik saat record dihapus
        static::deleting(function (Document $document) {
            Storage::disk('local')->delete($document->file_path);
        });
    }
}
