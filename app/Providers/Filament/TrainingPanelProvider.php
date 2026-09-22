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
 * Portal Guru — pelaporan kelas, absensi, nilai.
 * Akses: admin + teacher (tanpa IP allowlist — guru mengakses dari mana saja;
 * keamanan dari auth + AuthenticateSession + throttle login bawaan Filament).
 */
class TrainingPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('training')
            ->path('training')
            ->login()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->brandName('IF Training Portal')
            ->discoverResources(in: app_path('Filament/Training/Resources'), for: 'App\\Filament\\Training\\Resources')
            ->discoverPages(in: app_path('Filament/Training/Pages'), for: 'App\\Filament\\Training\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Training/Widgets'), for: 'App\\Filament\\Training\\Widgets')
            ->widgets([
                AccountWidget::class,
                \App\Filament\Training\Widgets\ClassStats::class,
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
                EnsureRole::class . ':admin,teacher',
            ]);
    }
}
