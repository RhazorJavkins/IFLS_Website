<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Tamu yang menyentuh route ter-proteksi diarahkan ke login portal yang sesuai:
        // /admin/* → /admin/login, /training/* → /training/login, dst. (default → /admin/login)
        \Illuminate\Auth\Middleware\Authenticate::redirectUsing(function (\Illuminate\Http\Request $request) {
            $segment = $request->path();

            return match (true) {
                str_starts_with($segment, 'training') => route('filament.training.auth.login'),
                str_starts_with($segment, 'translate') => route('filament.translate.auth.login'),
                default => route('filament.admin.auth.login'),
            };
        });
        // Hardening SQLite (dev): paksa foreign key, tunggu lock (hindari "database is locked"),
        // dan WAL untuk concurrency baca-tulis yang lebih baik.
        if (config('database.default') === 'sqlite') {
            $db = \Illuminate\Support\Facades\DB::connection();
            $db->getPdo()->exec('PRAGMA foreign_keys = ON');
            $db->getPdo()->exec('PRAGMA busy_timeout = 5000');
            $db->getPdo()->exec('PRAGMA journal_mode = WAL');
        }
    }
}
