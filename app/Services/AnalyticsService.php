<?php

namespace App\Services;

use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;
use Spatie\Analytics\Facades\Analytics as AnalyticsFacade;

/**
 * Wrapper fetch GA4 Data API untuk dashboard admin.
 *
 * Semua method aman dipanggil tanpa konfigurasi: jika ANALYTICS_PROPERTY_ID
 * atau kredensial service account belum diisi, dikembalikan null (bukan exception)
 * sehingga widget bisa menampilkan pesan "belum dikonfigurasi".
 * Respons API di-cache oleh spatie/laravel-analytics (24 jam, bisa dibersihkan
 * via `php artisan cache:clear`).
 */
class AnalyticsService
{
    /** GA4 dianggap terkonfigurasi bila property ID ada dan file kredensial ada. */
    public static function configured(): bool
    {
        return ! empty(config('analytics.property_id'))
            && file_exists(config('analytics.service_account_credentials_json'));
    }

    /** [tanggal, visitors, pageviews] per hari selama $days. */
    public static function dailySeries(int $days): ?array
    {
        if (! self::configured()) {
            return null;
        }

        try {
            return AnalyticsFacade::fetchVisitorsAndPageViewsByDate(Period::days($days))
                ->map(fn ($row) => [
                    'date' => $row['date']->format('Y-m-d'),
                    'visitors' => (int) $row['activeUsers'],
                    'pageviews' => (int) $row['screenPageViews'],
                ])
                ->all();
        } catch (\Throwable) {
            return null;
        }
    }

    /** Total pengunjung unik & pageviews selama $days. */
    public static function totals(int $days): ?array
    {
        $series = self::dailySeries($days);

        if ($series === null) {
            return null;
        }

        // activeUsers tidak bisa dijumlah antar-hari secara sempurna, tapi cukup akurat untuk overview.
        return [
            'visitors' => array_sum(array_column($series, 'visitors')),
            'pageviews' => array_sum(array_column($series, 'pageviews')),
        ];
    }

    /** N halaman terpopuler: [path, views]. */
    public static function topPages(int $days, int $limit = 10): ?array
    {
        if (! self::configured()) {
            return null;
        }

        try {
            return AnalyticsFacade::fetchMostVisitedPages(Period::days($days), $limit)
                ->map(fn ($row) => [
                    'path' => $row['fullPageUrl'] ?? $row['pageTitle'],
                    'views' => (int) $row['screenPageViews'],
                ])
                ->all();
        } catch (\Throwable) {
            return null;
        }
    }
}
