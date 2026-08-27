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

    {{-- Statistik — sinkron: 10.000+ / 2012 / 100+ --}}
    <div class="row text-center g-4 mb-5">
        <div class="col-md-4">
            <div class="p-4 border rounded-3 h-100 shadow-sm">
                <i class="fas fa-user-graduate fa-2x text-primary mb-3"></i>
                <h2 class="fw-bold mb-0">10,000+</h2>
                <p class="text-muted mb-0">{{ __('messages.stat_students') }}</p>
                <small class="text-muted">{{ __('messages.stat_students_sub') }}</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border rounded-3 h-100 shadow-sm">
                <i class="fas fa-award fa-2x text-primary mb-3"></i>
                <h2 class="fw-bold mb-0">2012</h2>
                <p class="text-muted mb-0">{{ __('messages.stat_years') }}</p>
                <small class="text-muted">{{ __('messages.stat_years_sub') }}</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border rounded-3 h-100 shadow-sm">
                <i class="fas fa-handshake fa-2x text-primary mb-3"></i>
                <h2 class="fw-bold mb-0">100+</h2>
                <p class="text-muted mb-0">{{ __('messages.stat_partners') }}</p>
                <small class="text-muted">{{ __('messages.stat_partners_sub') }}</small>
            </div>
        </div>
    </div>

    {{-- Visi Misi — 1 bahasa per locale --}}
    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm border-0" style="border-left:4px solid #1a2a4f !important;">
                <div class="card-body p-4">
                    <h3 class="h5 fw-bold"><i class="fas fa-eye text-primary me-2"></i>{{ __('messages.vision_title') }}</h3>
                    <p class="mb-0 text-muted">{{ __('messages.vision_text') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm border-0" style="border-left:4px solid #b03a3a !important;">
                <div class="card-body p-4">
                    <h3 class="h5 fw-bold"><i class="fas fa-bullseye text-danger me-2"></i>{{ __('messages.mission_title') }}</h3>
                    <p class="mb-3 text-muted">{{ __('messages.mission_text') }}</p>
                    <ul class="mb-0 small text-muted ps-3">
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

    {{-- ===== BEKERJASAMA DENGAN UNIVERSITAS — slider ===== --}}
    <section id="universitas" class="mt-5 pt-4">
        <div class="text-center mb-4">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3"><i class="fa-solid fa-graduation-cap me-1"></i> {{ __('messages.uni_badge') }}</span>
            <h2 class="fw-bold mb-2">{{ __('messages.uni_title') }}</h2>
            <p class="text-muted mx-auto" style="max-width:640px;">{{ __('messages.uni_desc') }}</p>
        </div>
        <div class="position-relative uni-slider-wrap">
            <button class="btn btn-light shadow-sm rounded-circle position-absolute top-50 start-0 translate-middle-y d-none d-md-flex align-items-center justify-content-center uni-prev" type="button" data-target="uniSliderAbout" style="width:38px;height:38px; z-index:2; left:-12px !important;"><i class="fa-solid fa-chevron-left small"></i></button>
            <button class="btn btn-light shadow-sm rounded-circle position-absolute top-50 end-0 translate-middle-y d-none d-md-flex align-items-center justify-content-center uni-next" type="button" data-target="uniSliderAbout" style="width:38px;height:38px; z-index:2; right:-12px !important;"><i class="fa-solid fa-chevron-right small"></i></button>
            <div id="uniSliderAbout" class="uni-slider d-flex gap-3 overflow-auto flex-nowrap pb-2 px-1" style="scroll-snap-type:x mandatory; scrollbar-width:none; -ms-overflow-style:none;">
                @php $unis = [['Universitas Indonesia','UI','Depok','#1a2a4f'],['Universitas Padjadjaran','UNPAD','Jatinangor','#b03a3a'],['Universitas Al Azhar Indonesia','UAI','Jakarta','#2d6a4f'],['Universitas Bunda Mulia','UBM','Jakarta','#7a5200'],['Universitas Gadjah Mada','UGM','Yogyakarta','#1a2a4f'],['Universitas Ciputra','UC','Surabaya','#2d6a4f']]; @endphp
                @foreach($unis as $u)
                    <div class="flex-shrink-0" style="width:240px; scroll-snap-align:start;">
                        <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4 uni-card">
                            <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width:56px;height:56px;background:{{ $u[3] }};">{{ $u[1] }}</div>
                            <h6 class="fw-bold mb-1" style="font-size:.85rem;">{{ $u[0] }}</h6>
                            <div class="small text-muted">{{ $u[2] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center small text-muted mt-2 d-md-none"><i class="fa-solid fa-arrows-left-right me-1"></i> Geser untuk melihat lainnya</div>
        </div>
    </section>

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
                        <p class="small text-muted mb-2">{{ __('messages.about_director_yi_desc') }}</p>
                        <div class="small text-muted">{{ __('messages.about_director_yi_role') }}</div>
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
                        <div class="badge bg-warning bg-opacity-20 mb-2 px-3 py-2" style="color:#7a5200;">{{ __('messages.about_director_amber_badge') }}</div>
                        <p class="small text-muted mb-2">{{ __('messages.about_director_amber_desc') }}</p>
                        <div class="small text-muted">{{ __('messages.about_director_amber_role') }}</div>
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
                    ['cn'=>'玉雪慧', 'py'=>'Xiao Yu', 'role_cn'=>'总经理', 'role_id'=>'General Manager', 'role_en'=>'General Manager', 'color'=>'#1a2a4f', 'icon'=>'fa-crown'],
                    ['cn'=>'潘炫颖', 'py'=>'Novi', 'role_cn'=>'培训总监', 'role_id'=>'Training Director', 'role_en'=>'Training Director', 'color'=>'#b03a3a', 'icon'=>'fa-chalkboard-user'],
                    ['cn'=>'洪莉莎', 'py'=>'Elissa', 'role_cn'=>'教研主管', 'role_id'=>'Curriculum Supervisor', 'role_en'=>'Curriculum Supervisor', 'color'=>'#2d6a4f', 'icon'=>'fa-book-open'],
                    ['cn'=>'李美慧', 'py'=>'Susanty', 'role_cn'=>'教务主管', 'role_id'=>'Academic Supervisor', 'role_en'=>'Academic Supervisor', 'color'=>'#7a5200', 'icon'=>'fa-clipboard-check'],
                    ['cn'=>'吴丽娜', 'py'=>'Rina', 'role_cn'=>'教学主管', 'role_id'=>'Teaching Supervisor', 'role_en'=>'Teaching Supervisor', 'color'=>'#2d4a7a', 'icon'=>'fa-people-group'],
                ];
                $locale = app()->getLocale();
            @endphp

            @foreach($team as $m)
                <div class="col-6 col-md-4 col-lg">
                    <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3 team-card">
                        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center text-white" style="width:64px;height:64px; background: {{ $m['color'] }};">
                            <i class="fa-solid {{ $m['icon'] }} fa-lg"></i>
                        </div>
                        {{-- Nama 1 baris: CN + alfabet --}}
                        <h6 class="fw-bold mb-1" style="font-size:.85rem;">{{ $m['cn'] }} <span class="fw-normal text-muted">{{ $m['py'] }}</span></h6>
                        {{-- Jabatan 1 bahasa saja per locale --}}
                        <div class="small text-muted" style="font-size:.72rem;">@if($locale==='zh'){{ $m['role_cn'] }}@elseif($locale==='en'){{ $m['role_en'] }}@else{{ $m['role_id'] }}@endif</div>
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
    .uni-card, .team-card { transition: transform .18s ease, box-shadow .18s ease; }
    .uni-card:hover, .team-card:hover { transform: translateY(-5px); box-shadow: 0 .75rem 1.5rem rgba(0,0,0,.12) !important; }
</style>
@endsection
