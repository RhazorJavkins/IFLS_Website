<?php

namespace App\Filament\Widgets;

use App\Models\ContactLead;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Str;

class LeadStats extends BaseWidget
{
    protected ?string $heading = 'Statistik Leads';

    protected function getStats(): array
    {
        $topProgram = ContactLead::query()
            ->whereNotNull('program')
            ->groupBy('program')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->value('program');

        return [
            Stat::make('Lead Baru (7 hari)', ContactLead::where('created_at', '>=', now()->subDays(7))->count())
                ->description('Dari form kontak website')
                ->color('success')
                ->icon('heroicon-m-inbox-arrow-down'),
            Stat::make('Belum Dihubungi', ContactLead::whereNull('contacted_at')->count())
                ->description('Perlu tindak lanjut')
                ->color('warning')
                ->icon('heroicon-m-clock'),
            Stat::make('Total Lead', ContactLead::count())
                ->description('Sejak awal')
                ->color('primary')
                ->icon('heroicon-m-users'),
            Stat::make('Program Terpopuler', Str::limit($topProgram ?: '—', 20))
                ->description('Berdasarkan jumlah lead')
                ->color('info')
                ->icon('heroicon-m-star'),
        ];
    }
}
