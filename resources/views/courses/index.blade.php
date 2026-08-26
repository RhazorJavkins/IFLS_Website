@extends('layouts.app')

@section('title', __('messages.our_courses'))

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">{{ __('messages.our_courses') }}</h1>

    <!-- Filter Level -->
    <div class="row mb-4">
        <div class="col-md-6 mx-auto">
            <form method="GET" action="{{ url('/' . app()->getLocale() . '/courses') }}" class="d-flex gap-2">
                <select name="level" class="form-select">
                    <option value="">{{ __('messages.all_levels') }}</option>
                    <option value="Pemula" {{ request('level') == 'Pemula' ? 'selected' : '' }}>
                        {{ __('messages.levels.Pemula') }}
                    </option>
                    <option value="Menengah" {{ request('level') == 'Menengah' ? 'selected' : '' }}>
                        {{ __('messages.levels.Menengah') }}
                    </option>
                    <option value="Lanjutan" {{ request('level') == 'Lanjutan' ? 'selected' : '' }}>
                        {{ __('messages.levels.Lanjutan') }}
                    </option>
                </select>
                <button type="submit" class="btn btn-primary">{{ __('messages.filter') }}</button>
                @if(request('level'))
                    <a href="{{ url('/' . app()->getLocale() . '/courses') }}" class="btn btn-secondary">{{ __('messages.reset') }}</a>
                @endif
            </form>
        </div>
    </div>

    <!-- Level & Materi -->
    <div class="row mb-2">
        <div class="col-12 text-center">
            <h2>{{ __('messages.level_and_materials') }}</h2>
            <p class="text-muted">{{ __('messages.level_and_materials_subtitle') }}</p>
        </div>
    </div>
    <div class="row g-4 mb-5">
        @foreach(['Pemula', 'Menengah', 'Lanjutan'] as $lvl)
            @php $info = __('messages.levels_info.' . $lvl); @endphp
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <span class="badge bg-primary">{{ __('messages.levels.' . $lvl) }}</span>
                        </h5>
                        <p class="card-text text-muted">{{ $info['desc'] }}</p>
                        <h6 class="mt-3">{{ __('messages.materials_taught') }}</h6>
                        <ul class="list-unstyled mb-3">
                            @foreach($info['materials'] as $material)
                                <li><i class="fas fa-check-circle text-success me-2"></i>{{ $material }}</li>
                            @endforeach
                        </ul>
                        <a href="{{ url('/' . app()->getLocale() . '/courses?level=' . $lvl) }}" class="btn btn-outline-primary btn-sm">
                            {{ __('messages.view_level_courses') }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Grid Kursus -->
    <div class="row g-4">
        @forelse($courses as $course)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->translated_name }}</h5>
                        <p class="card-text text-muted">
                            <small>
                                <i class="fas fa-tag"></i> {{ \Illuminate\Support\Facades\Lang::has('messages.levels.' . $course->level) ? __('messages.levels.' . $course->level) : $course->level }} &nbsp;|&nbsp;
                                <i class="fas fa-clock"></i> {{ $course->duration }} {{ __('messages.hours') }}
                            </small>
                        </p>
                        <p class="card-text">{{ Str::limit($course->translated_description, 100) }}</p>
                        <h6 class="text-primary">Rp {{ number_format($course->price, 0, ',', '.') }}</h6>
                        <a href="{{ route('courses.show', ['locale' => app()->getLocale(), 'course' => $course->id]) }}" class="btn btn-outline-primary mt-2">
                            {{ __('messages.read_more') }}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>{{ __('messages.no_courses') }}</p>
            </div>
        @endforelse
    </div>
</div>
@endsection