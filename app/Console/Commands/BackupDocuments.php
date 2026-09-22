<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Backup dokumen privat portal translate (storage/app/private/documents)
 * menjadi satu ZIP di storage/app/backups.
 *
 * Pemakaian: php artisan documents:backup {--keep=14}
 * Dijadwalkan harian 23:05 (setelah db:backup 23:00) via routes/console.php.
 * Di produksi (VPS) jalur disk bisa berbeda — perintah ini tetap membaca
 * disk 'local' sesuai konfigurasi filesystems.
 */
class BackupDocuments extends Command
{
    protected $signature = 'documents:backup {--keep=14 : Jumlah arsip yang dipertahankan}';

    protected $description = 'Backup dokumen privat portal translate ke ZIP di storage/app/backups';

    public function handle(): int
    {
        if (! class_exists(\ZipArchive::class)) {
            $this->error('Ekstensi PHP zip tidak aktif — aktifkan extension=zip (wajib juga untuk Filament).');

            return self::FAILURE;
        }

        $disk = Storage::disk('local');
        $files = collect($disk->allFiles('documents'))->filter(fn ($f) => $disk->size($f) >= 0);

        $dir = storage_path('app/backups');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $target = $dir . '/documents-' . now()->format('Y-m-d-His') . '.zip';

        $zip = new \ZipArchive;

        if ($zip->open($target, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            $this->error('Gagal membuat arsip: ' . $target);

            return self::FAILURE;
        }

        $count = 0;
        foreach ($files as $file) {
            $full = $disk->path($file);

            if (is_file($full)) {
                $zip->addFile($full, $file);
                $count++;
            }
        }

        $zip->close();

        if ($count === 0) {
            @unlink($target);
            $this->info('Tidak ada dokumen untuk dibackup — arsip kosong dilewati.');

            return self::SUCCESS;
        }

        $this->info("Backup dokumen dibuat: {$target} ({$count} file)");

        // Retensi
        $keep = max(1, (int) $this->option('keep'));
        $backups = collect(glob($dir . '/documents-*.zip'))->sort();
        $stale = $backups->slice(0, max(0, $backups->count() - $keep));

        foreach ($stale as $file) {
            @unlink($file);
            $this->line('Dihapus (retensi): ' . basename($file));
        }

        return self::SUCCESS;
    }
}
