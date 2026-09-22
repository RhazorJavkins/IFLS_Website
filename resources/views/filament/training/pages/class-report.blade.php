<x-filament-panels::page>
    <div class="space-y-4">
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-white/10 dark:bg-gray-900">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Laporan — {{ $record->name }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $rows->count() }} murid · {{ $record->sessions->count() }} pertemuan
                @if ($record->location)
                    · 📍 {{ $record->location }}
                @endif
                @if ($record->period)
                    · 🗓 {{ $record->period }}
                @endif
            </p>
        </div>

        {{-- Murid berisiko --}}
        @if ($risk)
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-900/40 dark:bg-red-950/30">
                <h3 class="font-semibold text-red-700 dark:text-red-300">⚠️ Murid Berisiko</h3>
                <ul class="mt-2 space-y-1 text-sm text-red-700 dark:text-red-200">
                    @foreach ($risk as $item)
                        <li>
                            <b>{{ $item['student']->name }}</b>
                            — {{ $item['absences'] }}× alpa
                            @if (is_numeric($item['average'])) · rata-rata {{ $item['average'] }} @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tabel rekap --}}
        <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm dark:border-white/10 dark:bg-gray-900">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 dark:text-gray-400">
                        <th class="px-4 py-2 font-medium">Murid</th>
                        <th class="px-4 py-2 font-medium">Kehadiran</th>
                        <th class="px-4 py-2 font-medium">Alpa</th>
                        <th class="px-4 py-2 font-medium">Nilai (tertimbang)</th>
                        <th class="px-4 py-2 font-medium text-right">Kontak</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $row)
                        @php
                            $attendanceColor = $row['attendance'] === null ? 'text-gray-400'
                                : ($row['attendance'] >= 85 ? 'text-green-600' : ($row['attendance'] >= 70 ? 'text-amber-600' : 'text-red-600'));
                            $avgColor = $row['average'] === null ? 'text-gray-400'
                                : ($row['average'] >= 80 ? 'text-green-600' : ($row['average'] >= 70 ? 'text-amber-600' : 'text-red-600'));
                        @endphp
                        <tr class="border-t border-gray-100 dark:border-white/5">
                            <td class="px-4 py-2 font-medium text-gray-900 dark:text-white">{{ $row['student']->name }}</td>
                            <td class="px-4 py-2 font-semibold {{ $attendanceColor }}">
                                {{ $row['attendance'] === null ? '—' : $row['attendance'] . '%' }}
                            </td>
                            <td class="px-4 py-2 text-gray-700 dark:text-gray-300">{{ $row['absences'] }}×</td>
                            <td class="px-4 py-2 font-semibold {{ $avgColor }}">
                                {{ $row['average'] ?? '—' }}
                            </td>
                            <td class="px-4 py-2 text-right">
                                @if ($row['wa'])
                                    <a href="{{ $row['wa'] }}" target="_blank" rel="noopener"
                                       class="inline-flex items-center gap-1 rounded-lg bg-green-500/10 px-3 py-1 text-xs font-semibold text-green-600 hover:bg-green-500/20">
                                        WhatsApp ↗
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400">tanpa no. WA</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @if ($rows->isEmpty())
                        <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada murid di kelas ini.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="flex gap-4">
            <a href="{{ \App\Filament\Training\Resources\ClassResource::getUrl('view', ['record' => $record]) }}"
               class="text-sm text-gray-500 underline hover:text-gray-700">← Kembali ke kelas</a>
            <a href="{{ $attendanceCsv }}" class="text-sm text-gray-500 underline hover:text-gray-700">CSV absensi</a>
            <a href="{{ $gradesCsv }}" class="text-sm text-gray-500 underline hover:text-gray-700">CSV nilai</a>
        </div>
    </div>
</x-filament-panels::page>
