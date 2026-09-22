<x-filament-panels::page>
    <div class="space-y-4">
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-white/10 dark:bg-gray-900">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Nilai — {{ $record->name }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Skor tertimbang per murid; rata-rata & detail lengkap di halaman Laporan.</p>
        </div>

        {{ $this->table }}

        <div class="flex gap-3">
            <a href="{{ \App\Filament\Training\Resources\ClassResource::getUrl('view', ['record' => $record]) }}"
               class="text-sm text-gray-500 underline hover:text-gray-700">← Kembali ke kelas</a>
            <a href="{{ $csvUrl }}" class="text-sm text-gray-500 underline hover:text-gray-700">Unduh CSV nilai</a>
        </div>
    </div>
</x-filament-panels::page>
