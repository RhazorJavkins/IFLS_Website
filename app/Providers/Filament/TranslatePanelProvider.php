<?php

namespace App\Providers\Filament;

use App\Http\Middleware\EnsureRole;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * Portal Penerjemahan — penyimpanan dokumen & follow-up leads website.
 * Akses: admin + translator (tanpa IP allowlist; dokumen disimpan di disk
 * privat, unduhan hanya lewat route ter-proteksi auth).
 */
class TranslatePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('translate')
            ->path('translate')
            ->login()
            ->colors([
                'primary' => Color::Teal,
            ])
            ->brandName('IF Translate Portal')
            ->discoverResources(in: app_path('Filament/Translate/Resources'), for: 'App\\Filament\\Translate\\Resources')
            ->discoverPages(in: app_path('Filament/Translate/Pages'), for: 'App\\Filament\\Translate\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Translate/Widgets'), for: 'App\\Filament\\Translate\\Widgets')
            ->widgets([
                AccountWidget::class,
                \App\Filament\Translate\Widgets\TranslateStats::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                EnsureRole::class . ':admin,translator',
            ]);
    }
}
