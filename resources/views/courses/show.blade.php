@extends('layouts.app')

@section('title', $course->translated_name)

@section('content')
<div class="container py-5">
    <!-- Breadcrumb (Navigasi kembali ke daftar kursus) -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/' . app()->getLocale() . '/courses') }}">{{ __('messages.our_courses') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $course->translated_name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- KOLOM KIRI: Detail Kursus -->
        <div class="col-md-8">
            <h1>{{ $course->translated_name }}</h1>
            <p class="lead">{{ $course->translated_description }}</p>

            <div class="row mt-4">
                <div class="col-md-3">
                    <strong>{{ __('messages.level') }}</strong><br>
                    {{ \Illuminate\Support\Facades\Lang::has('messages.levels.' . $course->level) ? __('messages.levels.' . $course->level) : $course->level }}
                </div>
                <div class="col-md-3">
                    <strong>{{ __('messages.duration') }}</strong><br>
                    {{ $course->duration }} {{ __('messages.hours') }}
                </div>
                <div class="col-md-3">
                    <strong>{{ __('messages.price') }}</strong><br>
                    <span class="text-primary fw-bold">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                </div>
                <div class="col-md-3">
                    <strong>{{ __('messages.max_students') }}</strong><br>
                    {{ $course->max_students }} {{ __('messages.students') }}
                </div>
            </div>

            <hr class="my-4">

            <!-- JADWAL ONLINE -->
            <h4>🖥️ {{ __('messages.online_schedule') }}</h4>
            @if($onlineSchedules->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('messages.day') }}</th>
                                <th>{{ __('messages.time') }}</th>
                                <th>{{ __('messages.instructor') }}</th>
                                <th>{{ __('messages.quota') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($onlineSchedules as $schedule)
                                <tr>
                                    <td>{{ \Illuminate\Support\Facades\Lang::has('messages.days.' . $schedule->day) ? __('messages.days.' . $schedule->day) : $schedule->day }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                                    <td>{{ $schedule->instructor }}</td>
                                    <td>{{ $schedule->quota }} {{ $schedule->is_full ? '(' . __('messages.full') . ')' : '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">{{ __('messages.no_online_schedule') }}</p>
            @endif

            <!-- JADWAL OFFLINE -->
            <h4 class="mt-4">🏫 {{ __('messages.offline_schedule') }}</h4>
            @if($offlineSchedules->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('messages.day') }}</th>
                                <th>{{ __('messages.time') }}</th>
                                <th>{{ __('messages.instructor') }}</th>
                                <th>{{ __('messages.room') }}</th>
                                <th>{{ __('messages.quota') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offlineSchedules as $schedule)
                                <tr>
                                    <td>{{ \Illuminate\Support\Facades\Lang::has('messages.days.' . $schedule->day) ? __('messages.days.' . $schedule->day) : $schedule->day }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                                    <td>{{ $schedule->instructor }}</td>
                                    <td>{{ $schedule->room }}</td>
                                    <td>{{ $schedule->quota }} {{ $schedule->is_full ? '(' . __('messages.full') . ')' : '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">{{ __('messages.no_offline_schedule') }}</p>
            @endif

            <!-- Tombol Daftar (Nanti akan diintegrasikan di Week 2) -->
            <div class="mt-4">
                <a href="#" class="btn btn-primary btn-lg">{{ __('messages.register_now') }}</a>
            </div>
        </div>

        <!-- KOLOM KANAN: Sidebar -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>{{ __('messages.info') }}</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check-circle text-success"></i> {{ __('messages.certificate') }}</li>
                        <li><i class="fas fa-check-circle text-success"></i> {{ __('messages.professional_teachers') }}</li>
                        <li><i class="fas fa-check-circle text-success"></i> {{ __('messages.small_class', ['count' => $course->max_students]) }}</li>
                        <li><i class="fas fa-check-circle text-success"></i> {{ __('messages.free_trial') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection