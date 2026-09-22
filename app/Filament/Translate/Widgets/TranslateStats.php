<?php

namespace App\Filament\Translate\Widgets;

use App\Models\ContactLead;
use App\Models\Document;
use App\Models\TranslateJob;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TranslateStats extends BaseWidget
{
    protected ?string $heading = 'Ringkasan Penerjemahan';

    protected function getStats(): array
    {
        $active = TranslateJob::whereIn('status', ['incoming', 'in_progress', 'review'])->count();

        $nearDeadline = TranslateJob::whereIn('status', ['incoming', 'in_progress', 'review'])
            ->whereNotNull('deadline')
            ->whereBetween('deadline', [now()->startOfDay(), now()->addDays(7)->endOfDay()])
            ->count();

        $uncontacted = ContactLead::whereNull('contacted_at')->count();

        $docsThisMonth = Document::where('created_at', '>=', now()->startOfMonth())->count();

        return [
            Stat::make('Proyek Aktif', $active)
                ->description('Masuk / dikerjakan / review')
                ->color('primary')
                ->icon('heroicon-o-language'),
            Stat::make('Deadline ≤ 7 Hari', $nearDeadline)
                ->description($nearDeadline > 0 ? 'Perlu prioritas' : 'Aman')
                ->color($nearDeadline > 0 ? 'danger' : 'success')
                ->icon('heroicon-m-clock'),
            Stat::make('Leads Belum Dihubungi', $uncontacted)
                ->description('Dari form website')
                ->color($uncontacted > 0 ? 'warning' : 'success')
                ->icon('heroicon-m-inbox-arrow-down'),
            Stat::make('Dokumen Bulan Ini', $docsThisMonth)
                ->description('Diunggah ke portal')
                ->color('info')
                ->icon('heroicon-o-document-text'),
        ];
    }
}
