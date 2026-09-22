<x-filament-panels::page>
    @php
        $statusOptions = [
            'present' => 'Hadir',
            'excused' => 'Izin',
            'sick' => 'Sakit',
            'absent' => 'Alpa',
        ];
        $students = $record->students;
    @endphp

    <div class="space-y-4">
        {{-- Header kelas --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-white/10 dark:bg-gray-900">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $record->name }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $students->count() }} murid · {{ $sessions->count() }} pertemuan tercatat
            </p>
        </div>

        {{-- Buat pertemuan baru --}}
        <form wire:submit="addSession" class="rounded-xl border border-gray-200 bg-white p-4 dark:border-white/10 dark:bg-gray-900">
            <h3 class="mb-3 font-semibold text-gray-900 dark:text-white">Pertemuan Baru</h3>
            {{ $this->addSessionForm }}
            <div class="mt-3">
                <button type="submit" class="fi-btn fi-btn-color-primary fi-btn-size-md rounded-lg px-4 py-2 text-sm font-medium">+ Buat Pertemuan</button>
            </div>
        </form>

        @if ($sessions->isEmpty())
            <div class="rounded-xl border border-dashed border-gray-300 p-6 text-center text-gray-500 dark:border-white/10 dark:text-gray-400">
                Belum ada pertemuan. Buat pertemuan di atas untuk mulai mengisi absensi.
            </div>
        @else
            <form wire:submit="save" class="rounded-xl border border-gray-200 bg-white p-4 dark:border-white/10 dark:bg-gray-900">
                {{-- Pilih pertemuan --}}
                <div class="max-w-xl">
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Pertemuan</label>
                    <select wire:model.live="sessionId" wire:change="loadStatuses"
                            class="w-full rounded-lg border-gray-300 dark:border-white/10 dark:bg-gray-800 dark:text-white">
                        @foreach ($sessions as $s)
                            <option value="{{ $s->id }}">
                                P{{ $s->sequence }} · {{ $s->session_date->format('d M Y') }}{{ $s->material ? ' · ' . $s->material : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <h3 class="mt-4 mb-3 font-semibold text-gray-900 dark:text-white">
                    Daftar Hadir
                    @if ($session)
                        <span class="text-sm font-normal text-gray-500">— Pertemuan {{ $session->sequence }} · {{ $session->session_date->format('d M Y') }}</span>
                    @endif
                </h3>

                <div class="space-y-2">
                    @foreach ($students as $student)
                        <div class="flex flex-wrap items-center justify-between gap-2 rounded-lg border border-gray-100 p-3 dark:border-white/5">
                            <span class="font-medium text-gray-900 dark:text-white">{{ $student->name }}</span>
                            <div class="flex gap-1">
                                @foreach ($statusOptions as $value => $label)
                                    <button type="button"
                                        wire:click="$set('status.{{ $student->id }}', '{{ $value }}')"
                                        class="rounded-lg px-3 py-1.5 text-xs font-semibold ring-1 transition
                                            {{ ($status[$student->id] ?? null) === $value
                                                ? 'bg-amber-100 text-amber-800 ring-amber-300 dark:bg-amber-500/20 dark:text-amber-200'
                                                : 'bg-white text-gray-500 ring-gray-200 hover:bg-gray-50 dark:bg-transparent dark:text-gray-400 dark:ring-white/10' }}"
                                    >{{ $label }}</button>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @if ($students->isEmpty())
                        <p class="py-4 text-center text-gray-400">Belum ada murid di kelas ini — tambahkan lewat edit kelas.</p>
                    @endif
                </div>

                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <button type="submit" class="fi-btn fi-btn-color-primary fi-btn-size-md rounded-lg px-5 py-2 text-sm font-semibold">Simpan Absensi</button>
                    <a href="{{ $csvUrl }}" class="text-sm text-gray-500 underline hover:text-gray-700">Unduh CSV</a>
                    @if (session('saved'))
                        <span class="text-sm font-medium text-green-600">✓ Tersimpan</span>
                    @endif
                </div>
            </form>
        @endif
    </div>
</x-filament-panels::page>
