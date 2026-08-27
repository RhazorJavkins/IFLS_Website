@extends('layouts.app')

@section('title', __('messages.about'))

@section('content')
<div class="container py-5">

    {{-- Intro --}}
    <div class="row justify-content-center mb-5">
        <div class="col-lg-9 text-center">
            <h1 class="fw-bold mb-3">{{ __('messages.about') }}</h1>
            <p class="lead text-muted">{{ __('messages.about_intro') }}</p>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="row text-center g-4 mb-5">
        <div class="col-md-4">
            <div class="p-4 border rounded-3 h-100">
                <i class="fas fa-user-graduate fa-2x text-primary mb-3"></i>
                <h2 class="fw-bold mb-0">500+</h2>
                <p class="text-muted mb-0">{{ __('messages.stat_students') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border rounded-3 h-100">
                <i class="fas fa-award fa-2x text-primary mb-3"></i>
                <h2 class="fw-bold mb-0">8</h2>
                <p class="text-muted mb-0">{{ __('messages.stat_years') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border rounded-3 h-100">
                <i class="fas fa-handshake fa-2x text-primary mb-3"></i>
                <h2 class="fw-bold mb-0">25+</h2>
                <p class="text-muted mb-0">{{ __('messages.stat_partners') }}</p>
            </div>
        </div>
    </div>

    {{-- Visi Misi --}}
    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="h5 fw-bold"><i class="fas fa-eye text-primary me-2"></i>{{ __('messages.vision_title') }}</h3>
                    <p class="mb-0 text-muted">{{ __('messages.vision_text') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="h5 fw-bold"><i class="fas fa-bullseye text-primary me-2"></i>{{ __('messages.mission_title') }}</h3>
                    <ul class="mb-0 text-muted ps-3">
                        @foreach(__('messages.missions') as $m)
                            <li class="mb-1">{{ $m }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Keunggulan --}}
    <h2 class="text-center fw-bold mb-4">{{ __('messages.why_us') }}</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="text-center p-4 border rounded-3 h-100">
                <i class="fas fa-chalkboard-teacher fa-2x text-primary mb-3"></i>
                <h3 class="h6 fw-bold">{{ __('messages.why_1_title') }}</h3>
                <p class="text-muted small mb-0">{{ __('messages.why_1_desc') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center p-4 border rounded-3 h-100">
                <i class="fas fa-users fa-2x text-primary mb-3"></i>
                <h3 class="h6 fw-bold">{{ __('messages.why_2_title') }}</h3>
                <p class="text-muted small mb-0">{{ __('messages.why_2_desc') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center p-4 border rounded-3 h-100">
                <i class="fas fa-clock fa-2x text-primary mb-3"></i>
                <h3 class="h6 fw-bold">{{ __('messages.why_3_title') }}</h3>
                <p class="text-muted small mb-0">{{ __('messages.why_3_desc') }}</p>
            </div>
        </div>
    </div>

    {{-- ===== DIREKSI ===== --}}
    <section class="mt-5 pt-5 border-top">
        <div class="text-center mb-4">
            <span class="badge bg-dark text-white px-3 py-2 mb-3">{{ __('messages.about_director_badge') }}</span>
            <h2 class="fw-bold mb-2">{{ __('messages.about_director_title') }}</h2>
            <p class="text-muted mx-auto" style="max-width:620px;">{{ __('messages.about_director_desc') }}</p>
        </div>

        <div class="row g-4 justify-content-center">
            {{-- YI YAN --}}
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="card-body p-4 text-center">
                        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width:84px;height:84px; background: linear-gradient(135deg, #1a2a4f, #b03a3a); font-size:1.6rem;">
                            易
                        </div>
                        <h4 class="fw-bold mb-1">易衍 <span class="fw-normal text-muted">YI YAN</span></h4>
                        <div class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 py-2">董事长 · Chairman</div>
                        <p class="small text-muted mb-2">Founder IF Language School (2019) — Wirausahawan asal China, memulai perjalanan dengan membuat video berbahasa Mandarin tentang kehidupan di Indonesia untuk komunitas Tionghoa.</p>
                        <div class="small text-muted">Board Chairman / Chairperson</div>
                    </div>
                    <div class="card-footer bg-light border-0 text-center py-3">
                        <span class="small text-muted"><i class="fa-solid fa-quote-left me-1 text-primary"></i> Hai Nei Cun Zhi Ji, Tian Ya Ruo Bi Lin <i class="fa-solid fa-quote-right ms-1 text-primary"></i></span>
                    </div>
                </div>
            </div>

            {{-- Amber Liu --}}
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="card-body p-4 text-center">
                        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width:84px;height:84px; background: linear-gradient(135deg, #7a5200, #d4a017); font-size:1.6rem;">
                            刘
                        </div>
                        <h4 class="fw-bold mb-1">刘裕洁 <span class="fw-normal text-muted">Amber</span></h4>
                        <div class="badge bg-warning bg-opacity-20 mb-2 px-3 py-2" style="color:#7a5200;">Direktur · Director</div>
                        <p class="small text-muted mb-2">Mendampingi pengembangan kurikulum & kemitraan strategis, memastikan kualitas layanan bahasa di 3 kota: Jakarta, Semarang, Surabaya.</p>
                        <div class="small text-muted">Director</div>
                    </div>
                    <div class="card-footer bg-light border-0 text-center py-3">
                        <span class="small text-muted"><i class="fa-solid fa-handshake me-1 text-warning"></i> Bridging Two Cultures</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== OUR TEAM ===== --}}
    <section class="mt-5">
        <div class="text-center mb-4">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3">{{ __('messages.about_team_badge') }}</span>
            <h2 class="fw-bold mb-2">{{ __('messages.about_team_title') }}</h2>
            <p class="text-muted mx-auto" style="max-width:640px;">{{ __('messages.about_team_desc') }}</p>
        </div>

        <div class="row g-4">
            @php
                $team = [
                    ['cn'=>'玉雪慧', 'py'=>'Xiao Yu', 'id'=>'玉雪慧', 'role_cn'=>'总经理', 'role_id'=>'General Manager', 'role_en'=>'General Manager', 'color'=>'#1a2a4f', 'icon'=>'fa-crown'],
                    ['cn'=>'潘炫颖', 'py'=>'Novi', 'id'=>'潘炫颖 Novi', 'role_cn'=>'培训总监', 'role_id'=>'Training Director', 'role_en'=>'Training Director', 'color'=>'#b03a3a', 'icon'=>'fa-chalkboard-user'],
                    ['cn'=>'洪莉莎', 'py'=>'Elissa', 'id'=>'洪莉莎 Elissa', 'role_cn'=>'教研主管', 'role_id'=>'Curriculum and Research Supervisor', 'role_en'=>'Curriculum and Research Supervisor', 'color'=>'#2d6a4f', 'icon'=>'fa-book-open'],
                    ['cn'=>'李美慧', 'py'=>'Susanty', 'id'=>'李美慧 Susanty', 'role_cn'=>'教务主管', 'role_id'=>'Academic Affairs Supervisor', 'role_en'=>'Academic Affairs Supervisor', 'color'=>'#7a5200', 'icon'=>'fa-clipboard-check'],
                    ['cn'=>'吴丽娜', 'py'=>'Rina', 'id'=>'吴丽娜 Rina', 'role_cn'=>'教学主管', 'role_id'=>'Teaching Supervisor', 'role_en'=>'Teaching Supervisor', 'color'=>'#2d4a7a', 'icon'=>'fa-people-group'],
                ];
            @endphp

            @foreach($team as $m)
                <div class="col-6 col-md-4 col-lg">
                    <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3 team-card">
                        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center text-white" style="width:64px;height:64px; background: {{ $m['color'] }};">
                            <i class="fa-solid {{ $m['icon'] }} fa-lg"></i>
                        </div>
                        <h6 class="fw-bold mb-0">{{ $m['cn'] }} <span class="fw-normal text-muted small">{{ $m['py'] }}</span></h6>
                        <div class="small text-muted mb-1" style="font-size:.78rem;">{{ $m['id'] }}</div>
                        <div class="badge bg-light text-dark border small mb-1">{{ $m['role_cn'] }}</div>
                        <div class="small text-muted" style="font-size:.72rem;">{{ $m['role_id'] }}</div>
                    </div>
                </div>
            @endforeach

            {{-- Placeholder add more --}}
            <div class="col-6 col-md-4 col-lg">
                <div class="card h-100 border-2 border-dashed rounded-4 text-center p-3 d-flex flex-column align-items-center justify-content-center bg-light" style="border-color:#cbd5e1 !important; min-height: 210px;">
                    <div class="rounded-circle bg-white border d-flex align-items-center justify-content-center mb-3" style="width:64px;height:64px;">
                        <i class="fa-solid fa-plus text-muted fa-lg"></i>
                    </div>
                    <div class="small text-muted fw-bold">{{ __('messages.about_team_add_more') }}</div>
                    <div class="small text-muted" style="font-size:.72rem;">{{ __('messages.about_team_note') }}</div>
                </div>
            </div>
        </div>

        <div class="alert alert-light border d-flex gap-2 mt-4 small text-muted mb-0">
            <i class="fa-solid fa-database text-primary mt-1"></i>
            <span>{{ __('messages.about_team_note') }}</span>
        </div>
    </section>

</div>

<style>
    .team-card { transition: transform .18s ease, box-shadow .18s ease; }
    .team-card:hover { transform: translateY(-5px); box-shadow: 0 .75rem 1.5rem rgba(0,0,0,.12) !important; }
</style>
@endsection
