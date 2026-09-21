<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Backup database SQLite (dev/local). Di produksi (VPS + MySQL) ganti dengan
 * mysqldump harian + retensi serupa.
 * Pemakaian: php artisan db:backup  (dijadwalkan harian 23:00 via routes/console.php)
 */
class BackupSqlite extends Command
{
    protected $signature = 'db:backup {--keep=7 : Jumlah backup yang dipertahankan}';

    protected $description = 'Backup database SQLite ke storage/app/backups dengan retensi';

    public function handle(): int
    {
        $dbPath = database_path('database.sqlite');

        if (! file_exists($dbPath)) {
            $this->error('Database tidak ditemukan: ' . $dbPath);

            return self::FAILURE;
        }

        $dir = storage_path('app/backups');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $target = $dir . '/db-' . now()->format('Y-m-d-His') . '.sqlite';
        copy($dbPath, $target);
        $this->info('Backup dibuat: ' . $target);

        // Retensi: hapus backup terlama melebihi --keep
        $backups = collect(glob($dir . '/db-*.sqlite'))->sort();
        $keep = max(1, (int) $this->option('keep'));
        $stale = $backups->slice(0, max(0, $backups->count() - $keep));

        foreach ($stale as $file) {
            @unlink($file);
            $this->line('Dihapus (retensi): ' . basename($file));
        }

        return self::SUCCESS;
    }
}
