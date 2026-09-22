<?php

namespace App\Filament\Pages;

use App\Services\AnalyticsService;
use Filament\Pages\Page;

class AnalyticsDashboard extends Page
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-chart-bar';

    protected string $view = 'filament.pages.analytics-dashboard';

    protected static ?string $slug = 'analytics';

    protected static \UnitEnum|string|null $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Analitik';

    protected static ?string $title = 'Analitik Website (Google Analytics 4)';

    public int $days = 30;

    /** Pratinjau ringkasan untuk periode terpilih. */
    public function getSummaryProperty(): ?array
    {
        return AnalyticsService::totals($this->days);
    }

    public function getTopPagesProperty(): ?array
    {
        return AnalyticsService::topPages($this->days, 15);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\AnalyticsTrendChart::class,
        ];
    }
}
