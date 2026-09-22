<x-filament-panels::page>
    @php
        $summary = $this->summary;
        $topPages = $this->topPages;
    @endphp

    {{-- Pilihan periode --}}
    <div class="fi-btn-group mb-4 flex flex-wrap gap-2">
        @foreach ([7 => '7 hari', 14 => '14 hari', 30 => '30 hari'] as $value => $label)
            <button
                type="button"
                wire:click="$set('days', {{ $value }})"
                class="fi-btn {{ $days === $value ? 'fi-btn-color-primary' : 'fi-btn-color-gray' }} fi-btn-size-md rounded-lg px-4 py-2 text-sm font-medium ring-1 ring-gray-200 dark:ring-white/10"
            >{{ $label }}</button>
        @endforeach
    </div>

    @if ($summary === null)
        {{-- Fallback: belum dikonfigurasi / API gagal --}}
        <div class="fi-section rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-gray-900">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                ⚙️ Analitik belum dikonfigurasi
            </h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                Widget membutuhkan <b>service account Google</b> dengan akses GA4 Data API.
                Lihat petunjuk lengkap di <code>HANDOVER/README.md</code> — ringkasnya:
            </p>
            <ol class="mt-3 list-decimal space-y-1 pl-5 text-sm text-gray-600 dark:text-gray-300">
                <li>Buat Service Account di Google Cloud, aktifkan <b>Analytics Data API</b>.</li>
                <li>Berikan service account akses <b>Viewer</b> pada property GA4 (Admin → Property access management).</li>
                <li>Unduh file JSON kredensial → simpan ke <code>storage/app/analytics/service-account-credentials.json</code>.</li>
                <li>Isi <code>ANALYTICS_PROPERTY_ID</code> di <code>.env</code> (format <code>properties/123456789</code>, lihat GA4 Admin → Property details).</li>
                <li>Jalankan <code>php artisan config:clear</code>.</li>
            </ol>
        </div>
    @else
        {{-- Ringkasan periode --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-gray-900">
                <p class="text-sm text-gray-500 dark:text-gray-400">Pengunjung</p>
                <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($summary['visitors']) }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-gray-900">
                <p class="text-sm text-gray-500 dark:text-gray-400">Kunjungan halaman</p>
                <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($summary['pageviews']) }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-gray-900">
                <p class="text-sm text-gray-500 dark:text-gray-400">Halaman / kunjungan</p>
                <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $summary['visitors'] > 0 ? number_format($summary['pageviews'] / $summary['visitors'], 1) : '—' }}
                </p>
            </div>
        </div>

        {{-- Halaman terpopuler --}}
        @if (!empty($topPages))
            <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-white/10 dark:bg-gray-900">
                <h3 class="border-b border-gray-200 px-5 py-3 font-semibold text-gray-900 dark:border-white/10 dark:text-white">
                    Halaman Terpopuler
                </h3>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 dark:text-gray-400">
                            <th class="px-5 py-2 font-medium">Halaman</th>
                            <th class="px-5 py-2 text-right font-medium">Kunjungan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topPages as $page)
                            <tr class="border-t border-gray-100 dark:border-white/5">
                                <td class="px-5 py-2 text-gray-700 dark:text-gray-200">{{ \Illuminate\Support\Str::limit($page['path'], 70) }}</td>
                                <td class="px-5 py-2 text-right font-semibold text-gray-900 dark:text-white">{{ number_format($page['views']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif
</x-filament-panels::page>
