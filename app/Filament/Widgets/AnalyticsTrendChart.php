<?php

namespace App\Filament\Widgets;

use App\Services\AnalyticsService;
use Filament\Widgets\ChartWidget;

/**
 * Trend pengunjung harian dari GA4.
 * Tanpa konfigurasi kredensial → widget disembunyikan (bukan error).
 */
class AnalyticsTrendChart extends ChartWidget
{
    protected ?string $heading = 'Pengunjung Harian (30 hari)';

    protected ?string $pollingInterval = null;

    protected int|string|array $columnSpan = 'full';

    public ?string $filter = '30';

    protected function getFilters(): ?array
    {
        return [
            '7' => '7 hari',
            '14' => '14 hari',
            '30' => '30 hari',
        ];
    }

    protected function getData(): array
    {
        $series = AnalyticsService::dailySeries((int) $this->filter);

        if ($series === null) {
            return [];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pengunjung',
                    'data' => array_column($series, 'visitors'),
                    'backgroundColor' => 'rgba(245, 158, 11, 0.2)',
                    'borderColor' => '#f59e0b',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => array_map(
                fn ($row) => date('d M', strtotime($row['date'])),
                $series
            ),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    /** Sembunyikan widget sepenuhnya bila GA4 belum dikonfigurasi / API gagal. */
    protected function hasData(): bool
    {
        return AnalyticsService::dailySeries((int) $this->filter) !== null;
    }
}
