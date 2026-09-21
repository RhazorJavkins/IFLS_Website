@extends('layouts.app')

@section('title', __('messages.welcome_title'))

@section('content')

{{-- ===== 1. HERO PREMIUM — split + visual ===== --}}
<section class="hero-premium text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0f1e3a 0%, #1a2a4f 45%, #2d4a7a 70%, #b03a3a 100%); padding: 90px 0 80px;">
    <div class="container position-relative" style="z-index:2;">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 text-center text-lg-start">
                @if(!empty(__('messages.hero_badge')))
                    <span class="badge bg-warning text-dark mb-3 px-3 py-2 shadow-sm fw-semibold" style="letter-spacing:.3px; font-size:.75rem;"><i class="fa-solid fa-award me-1"></i> {{ __('messages.hero_badge') }}</span>
                @endif
                <h1 class="display-4 fw-bold mb-3" style="line-height:1.08; letter-spacing:-.5px;">
                    {{ __('messages.welcome_title') }}
                    <span class="d-block" style="background: linear-gradient(90deg, #FFD166, #ff9a76); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: clamp(1.5rem, 7vw, 3.5rem); white-space: nowrap;">Indonesia ⇄ China</span>
                </h1>
                <p class="lead mb-2" style="opacity:.92;">{{ __('messages.welcome_subtitle') }}</p>
                <p class="small mb-1" style="opacity:.70;"><i class="fa-solid fa-map-pin text-warning me-1"></i> {{ __('messages.home_campuses') }}</p>
                <p class="small mb-4" style="opacity:.70;"><i class="fa-solid fa-language me-1 text-warning"></i> {{ __('messages.home_hero_extra') }}</p>
                <div class="d-flex gap-3 justify-content-center justify-content-lg-start flex-wrap">
                    <a href="https://wa.me/628118887568?text=Halo%20IF%20Language%20School" target="_blank" class="btn btn-warning btn-lg px-4 fw-bold shadow">
                        <i class="fa-brands fa-whatsapp me-1"></i> {{ __('messages.register_now') }}
                    </a>
                    <a href="{{ url(app()->getLocale() . '/courses') }}" class="btn btn-outline-light btn-lg px-4">
                        {{ __('messages.hero_cta_courses') }}
                    </a>
                    <a href="{{ url(app()->getLocale() . '/services') }}" class="btn btn-light btn-lg px-4 fw-bold text-dark d-none d-sm-inline-flex align-items-center">
                        <i class="fa-solid fa-language me-1 text-primary"></i> {{ __('messages.services') }}
                    </a>
                </div>
                <div class="d-flex gap-3 justify-content-center justify-content-lg-start flex-wrap mt-4 small" style="opacity:.75;">
                    <span><i class="fa-solid fa-check-circle text-warning me-1"></i> 10.000+ alumni</span>
                    <span><i class="fa-solid fa-check-circle text-warning me-1"></i> {{ __('messages.translation_trust_1') }}</span>
                    <span><i class="fa-solid fa-check-circle text-warning me-1"></i> Online & Offline</span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative mx-auto" style="max-width: 460px;">
                    {{-- Main card --}}
                    <div class="bg-white rounded-4 p-4 shadow-lg text-dark position-relative" style="transform: rotate(-1.2deg);">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:52px;height:52px; background: linear-gradient(135deg, #1a2a4f, #b03a3a);">
                                <i class="fa-solid fa-language text-white fa-lg"></i>
                            </div>
                            <div>
                                <div class="fw-bold" style="letter-spacing:.5px;">ID ⇄ 中文 ⇄ EN</div>
                                <div class="small text-muted">{{ __('messages.hero_card_tagline') }}</div>
                            </div>
                            <span class="badge bg-success ms-auto">Live</span>
                        </div>
                        <div class="bg-light rounded-3 p-3 mb-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">{{ __('messages.hero_card_sample') }}</span><span class="fw-bold text-success">{{ __('messages.hero_card_satisfied') }}</span>
                            </div>
                            <div class="progress" style="height:7px;"><div class="progress-bar bg-success" style="width:92%"></div></div>
                            <div class="d-flex justify-content-between small text-muted mt-1">
                                <span><i class="fa-solid fa-users me-1"></i> {{ __('messages.hero_card_students') }}</span><span><i class="fa-solid fa-star text-warning me-1"></i> 4.9/5</span>
                            </div>
                        </div>
                        <div class="row g-2 text-center small">
                            <div class="col-4">
                                <div class="bg-primary bg-opacity-10 rounded-3 py-2">
                                    <div class="fw-bold text-primary">3</div><div class="text-muted" style="font-size:.65rem;">{{ __('messages.hero_card_cities') }}</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-warning bg-opacity-15 rounded-3 py-2">
                                    <div class="fw-bold" style="color:#7a5200;">24J</div><div class="text-muted" style="font-size:.65rem;">{{ __('messages.hero_card_express') }}</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-success bg-opacity-10 rounded-3 py-2">
                                    <div class="fw-bold text-success">{{ __('messages.hero_card_sworn') }}</div><div class="text-muted" style="font-size:.65rem;">{{ __('messages.hero_card_official') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Floating badge --}}
                    <div class="position-absolute bg-warning text-dark rounded-pill px-3 py-2 shadow fw-bold d-flex align-items-center gap-2" style="top:-12px; right:-10px; font-size:.78rem; transform: rotate(2deg);">
                        <i class="fa-solid fa-certificate"></i> Mitra Badan Bahasa Kemendikbudristek
                    </div>
                    <div class="position-absolute bg-white text-dark rounded-3 px-3 py-2 shadow d-flex align-items-center gap-2" style="bottom:-18px; left:-14px; font-size:.78rem;">
                        <span class="rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:#07C160;"><i class="fa-brands fa-weixin text-white"></i></span>
                        <div class="text-start"><div class="fw-bold" style="font-size:.78rem;">{{ __('messages.hero_card_wachat') }}</div><div class="small text-muted" style="font-size:.68rem;">{{ __('messages.hero_card_reply') }}</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="position-absolute" style="right:-80px; top:-80px; width:420px; height:420px; background: radial-gradient(circle, rgba(255,255,255,.08) 0%, transparent 70%); border-radius:50%;"></div>
    <div class="position-absolute" style="left:-100px; bottom:-100px; width:360px; height:360px; background: radial-gradient(circle, rgba(255,209,102,.10) 0%, transparent 70%); border-radius:50%;"></div>
    {{-- Wave bottom --}}
    <div class="position-absolute bottom-0 start-0 w-100" style="line-height:0;">
        <svg viewBox="0 0 1440 48" class="w-100" style="height:48px; display:block;" preserveAspectRatio="none">
            <path d="M0,24 C240,48 480,0 720,24 C960,48 1200,0 1440,24 L1440,48 L0,48 Z" fill="#f8f9fa" fill-opacity="1"></path>
        </svg>
    </div>
</section>

{{-- ===== 2. STATS STRIP ===== --}}
<section class="py-5 bg-light border-bottom">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-6 col-md-4">
                <h2 class="display-5 fw-bold text-primary mb-1">10,000+</h2>
                <p class="text-muted mb-0">{{ __('messages.stat_students') }}</p>
            </div>
            <div class="col-6 col-md-4">
                <h2 class="display-5 fw-bold text-primary mb-1">2012</h2>
                <p class="text-muted mb-0">{{ __('messages.stat_years') }}</p>
            </div>
            <div class="col-6 col-md-4 mx-auto">
                <h2 class="display-5 fw-bold text-primary mb-1">100+</h2>
                <p class="text-muted mb-0">{{ __('messages.stat_partners') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== 3. PROGRAM UNGGULAN (4) ===== --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">{{ __('messages.programs_title') }}</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">{{ __('messages.programs_intro') }}</p>
        </div>
        <div class="row g-4">
            @foreach ([
                ['icon' => 'fa-solid fa-language', 'title' => __('messages.prog_mandarin'), 'desc' => __('messages.prog_mandarin_desc'), 'color' => '#b03a3a', 'href' => 'courses#mandarin'],
                ['icon' => 'fa-solid fa-earth-asia', 'title' => __('messages.prog_indo'), 'desc' => __('messages.prog_indo_desc'), 'color' => '#1a2a4f', 'href' => 'courses#bahasa-indonesia'],
                ['icon' => 'fa-solid fa-graduation-cap', 'title' => __('messages.prog_english'), 'desc' => __('messages.prog_english_desc'), 'color' => '#2d6a4f', 'href' => 'courses#english'],
                ['icon' => 'fa-solid fa-briefcase', 'title' => __('messages.prog_corporate'), 'desc' => __('messages.prog_corporate_desc'), 'color' => '#7a5200', 'href' => 'courses#bahasa-indonesia'],
            ] as $prog)
                <div class="col-md-6 col-lg-3">
                    <a href="{{ url(app()->getLocale() . '/' . $prog['href']) }}" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm program-card">
                            <div class="card-body text-center p-4">
                                <div class="mb-3"><i class="{{ $prog['icon'] }} fa-2x" style="color: {{ $prog['color'] }}"></i></div>
                                <h5 class="card-title fw-bold text-dark">{{ $prog['title'] }}</h5>
                                <p class="card-text small text-muted">{{ $prog['desc'] }}</p>
                                <span class="small fw-bold" style="color: {{ $prog['color'] }}">{{ __('messages.read_more') }} <i class="fa-solid fa-arrow-right ms-1"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ url(app()->getLocale() . '/courses') }}" class="btn btn-primary px-4">
                {{ __('messages.view_all_courses') }} <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- ===== 4. LAYANAN TERJEMAHAN GRID (baru) ===== --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 mb-3 fw-semibold">{{ __('messages.home_translate_badge') }}</span>
            <h2 class="fw-bold mb-2">{{ __('messages.home_translate_title') }}</h2>
            <p class="text-muted mx-auto" style="max-width:620px;">{{ __('messages.home_translate_desc') }} — <a href="{{ url(app()->getLocale() . '/services') }}" class="text-decoration-none fw-bold">{{ __('messages.services') }} <i class="fa-solid fa-arrow-right ms-1"></i></a></p>
        </div>

        <div class="row g-4">
            {{-- 4 layanan compact --}}
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3 translate-card">
                    <div class="mx-auto mb-3 rounded-3 d-flex align-items-center justify-content-center" style="width:56px;height:56px;background:#e8f0ff;color:#1a2a4f;">
                        <i class="fa-solid fa-file-lines fa-lg"></i>
                    </div>
                    <h6 class="fw-bold mb-1">{{ __('messages.svc_doc_title') }}</h6>
                    <p class="small text-muted mb-2">{{ __('messages.svc_doc_desc') }}</p>
                    <div class="small text-muted mb-3" style="font-size:.75rem;">{{ __('messages.svc_doc_examples') }}</div>
                    <a href="{{ url(app()->getLocale() . '/services#layanan') }}" class="btn btn-outline-primary btn-sm w-100">{{ __('messages.translation_btn_quote') }}</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3 translate-card" style="border:1.5px solid #FFD166 !important;">
                    <span class="badge bg-warning text-dark position-absolute top-0 start-50 translate-middle px-2" style="font-size:.65rem;"><i class="fa-solid fa-star me-1"></i>{{ __('messages.svc_sworn_popular') }}</span>
                    <div class="mx-auto mb-3 rounded-3 d-flex align-items-center justify-content-center" style="width:56px;height:56px;background:#fff3cd;color:#7a5200;">
                        <i class="fa-solid fa-certificate fa-lg"></i>
                    </div>
                    <h6 class="fw-bold mb-1">{{ __('messages.svc_sworn_title') }}</h6>
                    <p class="small text-muted mb-2">{{ __('messages.svc_sworn_desc') }}</p>
                    <div class="small mb-3" style="font-size:.75rem; color:#7a5200;">{{ __('messages.svc_sworn_examples') }}</div>
                    <a href="{{ url(app()->getLocale() . '/services#layanan') }}" class="btn btn-warning btn-sm w-100 fw-bold">{{ __('messages.translation_btn_quote') }}</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3 translate-card">
                    <div class="mx-auto mb-3 rounded-3 d-flex align-items-center justify-content-center" style="width:56px;height:56px;background:#ffe8e8;color:#b03a3a;">
                        <i class="fa-solid fa-closed-captioning fa-lg"></i>
                    </div>
                    <h6 class="fw-bold mb-1">{{ __('messages.svc_video_title') }}</h6>
                    <p class="small text-muted mb-2">{{ __('messages.svc_video_desc') }}</p>
                    <div class="small text-muted mb-3" style="font-size:.75rem;">YouTube • TikTok • E-learning</div>
                    <a href="{{ url(app()->getLocale() . '/services#layanan') }}" class="btn btn-outline-dark btn-sm w-100">{{ __('messages.translation_btn_quote') }}</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3 translate-card">
                    <div class="mx-auto mb-3 rounded-3 d-flex align-items-center justify-content-center" style="width:56px;height:56px;background:#e6f4ea;color:#1b4332;">
                        <i class="fa-solid fa-comments fa-lg"></i>
                    </div>
                    <h6 class="fw-bold mb-1">{{ __('messages.svc_interp_title') }}</h6>
                    <p class="small text-muted mb-2">{{ __('messages.svc_interp_desc') }}</p>
                    <div class="small mb-3" style="font-size:.75rem; color:#1b4332;">On-site & Online</div>
                    <a href="{{ url(app()->getLocale() . '/services#layanan') }}" class="btn btn-success btn-sm w-100">{{ __('messages.translation_btn_quote') }}</a>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ url(app()->getLocale() . '/services') }}" class="btn btn-danger px-4 fw-bold">
                {{ __('messages.home_translate_cta') }} <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- ===== 5. MENGAPA KAMI ===== --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">{{ __('messages.why_us') }}</h2>
            <p class="text-muted mx-auto" style="max-width:640px;">{{ __('messages.why_us_desc') }}</p>
        </div>
        <div class="row g-3 g-md-4">
            @foreach ([1, 2, 3, 4, 5, 6] as $i)
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex gap-3 align-items-start h-100 p-3 p-md-4 rounded-4 border border-light shadow-sm bg-white">
                        <div class="flex-shrink-0 rounded-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px; background: rgba(26,42,79,.08);">
                            @if($i === 1)<i class="fa-solid fa-stamp text-warning fs-5"></i>
                            @elseif($i === 2)<i class="fa-solid fa-globe text-primary fs-5"></i>
                            @elseif($i === 3)<i class="fa-solid fa-city text-danger fs-5"></i>
                            @elseif($i === 4)<i class="fa-solid fa-award fs-5" style="color:#7a5200;"></i>
                            @elseif($i === 5)<i class="fa-brands fa-whatsapp fs-5 text-success"></i>
                            @else<i class="fa-solid fa-medal fs-5" style="color:#b03a3a;"></i>@endif
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">{{ __("messages.why_{$i}_title") }}</h6>
                            <p class="text-muted small mb-0">{{ __("messages.why_{$i}_desc") }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== 5b. BEKERJASAMA DENGAN UNIVERSITAS — slider ===== --}}
<section class="py-5 bg-light border-top border-bottom">
    <div class="container">
        <div class="text-center mb-4">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3"><i class="fa-solid fa-graduation-cap me-1"></i> {{ __('messages.uni_badge') }}</span>
            <h2 class="fw-bold mb-2">{{ __('messages.uni_title') }}</h2>
            <p class="text-muted mx-auto" style="max-width:640px;">{{ __('messages.uni_desc') }}</p>
        </div>
        <div class="position-relative uni-slider-wrap">
            <button class="btn btn-light shadow-sm rounded-circle position-absolute top-50 start-0 translate-middle-y d-none d-md-flex align-items-center justify-content-center uni-prev" type="button" data-target="uniSliderHome" style="width:38px;height:38px; z-index:2; left:-12px !important;"><i class="fa-solid fa-chevron-left small"></i></button>
            <button class="btn btn-light shadow-sm rounded-circle position-absolute top-50 end-0 translate-middle-y d-none d-md-flex align-items-center justify-content-center uni-next" type="button" data-target="uniSliderHome" style="width:38px;height:38px; z-index:2; right:-12px !important;"><i class="fa-solid fa-chevron-right small"></i></button>
            <div id="uniSliderHome" class="uni-slider d-flex gap-3 overflow-auto flex-nowrap pb-2 px-1" style="scroll-snap-type:x mandatory; scrollbar-width:none; -ms-overflow-style:none;">
                @php $unis = [['Universitas Indonesia','UI','Depok','#1a2a4f'],['Universitas Padjadjaran','UNPAD','Jatinangor','#b03a3a'],['Universitas Al Azhar Indonesia','UAI','Jakarta','#2d6a4f'],['Universitas Bunda Mulia','UBM','Jakarta','#7a5200'],['Universitas Gadjah Mada','UGM','Yogyakarta','#1a2a4f'],['Universitas Padjadjaran Ekstensi','UNPAD+','Bandung','#b03a3a']]; @endphp
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
            <div class="d-flex justify-content-center gap-2 mt-3 uni-dots" data-target="uniSliderHome">
                <span class="uni-dot active" style="width:8px;height:8px;border-radius:50%;background:#1a2a4f;display:inline-block;opacity:1;transition:all .2s;"></span>
                <span class="uni-dot" style="width:8px;height:8px;border-radius:50%;background:#adb5bd;display:inline-block;opacity:.6;transition:all .2s;"></span>
                <span class="uni-dot" style="width:8px;height:8px;border-radius:50%;background:#adb5bd;display:inline-block;opacity:.6;transition:all .2s;"></span>
            </div>
        </div>
        <div class="text-center mt-3">
            <a href="{{ url(app()->getLocale() . '/about#universitas') }}" class="btn btn-outline-primary px-4">{{ __('messages.uni_cta') }} <i class="fa-solid fa-arrow-right ms-1"></i></a>
        </div>
    </div>
</section>

{{-- ===== 6. TIM KAMI GRID (baru) ===== --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3">{{ __('messages.home_team_badge') }}</span>
            <h2 class="fw-bold mb-2">{{ __('messages.home_team_title') }}</h2>
            <p class="text-muted mx-auto" style="max-width:640px;">{{ __('messages.home_team_desc') }}</p>
        </div>

        <div class="row g-4 justify-content-center">
            @php
                $locale = app()->getLocale();
                $homeDirectors = \App\Models\TeamMember::query()->active()->where('is_director', true)->orderBy('sort')->get();
                $homeTeam = \App\Models\TeamMember::query()->active()->where('is_director', false)->orderBy('sort')->limit(6)->get();
                $homeCards = $homeDirectors->concat($homeTeam);
                if ($homeCards->isEmpty()) {
                    // Fallback config — situs tetap tampil walau DB kosong
                    $toCard = fn (array $d): object => (object) [
                        'name_cn' => $d['cn'], 'name' => $d['py'],
                        'photo_url' => asset('images/team/'.$d['photo']),
                        'translated_role' => $locale === 'zh' ? $d['role_cn'] : ($locale === 'en' ? $d['role_en'] : $d['role_id']),
                    ];
                    $homeCards = collect(config('team.directors', []))->map(fn ($d) => $toCard($d))
                        ->concat(collect(config('team.team', []))->take(config('team.home_limit', 4))->map(fn ($m) => $toCard($m)));
                }
            @endphp
            @foreach($homeCards as $m)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3 team-home-card">
                        <div class="team-photo-sm mx-auto mb-3">
                            <img src="{{ $m->photo_url }}" alt="{{ $m->name }}" loading="lazy" decoding="async">
                        </div>
                        <h6 class="fw-bold mb-0" style="font-size:.95rem;">{{ $m->name_cn }} <span class="fw-normal text-muted">{{ $m->name }}</span></h6>
                        <div class="small text-muted" style="font-size:.78rem;">{{ $m->translated_role }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ url(app()->getLocale() . '/about') }}" class="btn btn-outline-primary px-4">
                {{ __('messages.home_team_cta') }} <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- ===== 7. PARTNER KAMI GRID (baru) ===== --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-dark bg-opacity-10 text-dark px-3 py-2 mb-3">{{ __('messages.home_partner_badge') }}</span>
            <h2 class="fw-bold mb-2">{{ __('messages.home_partner_title') }}</h2>
            <p class="text-muted mx-auto" style="max-width:620px;">{{ __('messages.home_partner_desc') }}</p>
        </div>

        <div class="row g-3 align-items-stretch justify-content-center">
            @php
                $homePartners = [
                    ['Huawei', 'Teknologi', '#ff0000'],
                    ['Bank of China', 'Perbankan', '#b03a3a'],
                    ['Sinarmas', 'Konglomerat', '#1a2a4f'],
                    ['Midea', 'Manufaktur', '#0d6efd'],
                    ['Alibaba', 'E-commerce', '#ff6a00'],
                    ['BYD', 'Otomotif', '#198754'],
                    ['ICBC', 'Keuangan', '#7a1f1f'],
                    ['Tencent', 'Teknologi', '#2d4a7a'],
                ];
            @endphp
            @foreach($homePartners as $p)
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="partner-home-card bg-white border rounded-3 d-flex flex-column align-items-center justify-content-center text-center p-3 h-100 shadow-sm">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-2 fw-bold text-white" style="width:44px;height:44px;background:{{ $p[2] }}; font-size:.8rem;">
                            {{ strtoupper(substr($p[0],0,2)) }}
                        </div>
                        <div class="fw-bold small mb-0" style="font-size:.82rem;">{{ $p[0] }}</div>
                        <div class="text-muted" style="font-size:.68rem;">{{ $p[1] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ url(app()->getLocale() . '/gallery') }}" class="btn btn-outline-dark px-4">
                {{ __('messages.home_partner_cta') }} <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- ===== 8. TESTIMONI ===== --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">{{ __('messages.testimonials_title') }}</h2>
        </div>
        @php
            // DB-first: dari tabel testimonials (dikelola via /admin);
            // fallback ke lang file bila DB kosong.
            $testimonials = $dbTestimonials->isNotEmpty()
                ? $dbTestimonials
                : collect([1, 2, 3])->map(fn ($i) => (object) [
                    'id' => $i,
                    'initial' => mb_strtoupper(mb_substr(__("messages.testimonial{$i}_name"), 0, 1)),
                    'color' => ['#1a2a4f', '#b03a3a', '#2d6a4f'][$i - 1] ?? '#1a2a4f',
                    'translated_name' => __("messages.testimonial{$i}_name"),
                    'translated_content' => __("messages.testimonial{$i}"),
                ]);
        @endphp
        <div class="row g-4">
            @foreach ($testimonials as $t)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0" style="width:48px;height:48px;background:{{ $t->color }};">{{ $t->initial }}</div>
                                <div>
                                    <p class="mb-0 fw-bold small">{{ $t->translated_name }}</p>
                                    <div class="text-warning small">
                                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="card-text fst-italic mb-0">“{{ $t->translated_content }}”</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== 10. FAQ ACCORDION ===== --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3"><i class="fa-solid fa-circle-question me-1"></i> FAQ</span>
            <h2 class="fw-bold">{{ __('messages.faq_title') }}</h2>
            <p class="text-muted mx-auto" style="max-width:560px;">{{ __('messages.faq_subtitle') }}</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion accordion-flush" id="faqAccordion">
                    {{-- DB-first dengan fallback ke lang file --}}
                    @php
                        $faqList = $dbFaqs->isNotEmpty()
                            ? $dbFaqs->map(fn ($f) => ['id' => $f->id, 'q' => $f->translated_question, 'a' => $f->translated_answer])->all()
                            : collect(__('messages.faq_items'))->map(fn ($f, $i) => ['id' => $i, 'q' => $f['q'], 'a' => $f['a']])->all();
                    @endphp
                    @foreach ($faqList as $faq)
                    <div class="accordion-item border mb-2 rounded-3 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ ! $loop->first ? 'collapsed' : ''}}" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $faq['id'] }}">
                                {{ $faq['q'] }}
                            </button>
                        </h2>
                        <div id="faq{{ $faq['id'] }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">{{ $faq['a'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 11. CTA AKHIR — sinkron ===== --}}
<section class="py-5 text-white text-center position-relative overflow-hidden" style="background: linear-gradient(135deg, #1a2a4f 0%, #2d4a7a 100%);">
    <div class="container py-3 position-relative" style="z-index:2;">
        <h2 class="fw-bold mb-3">{{ __('messages.cta_final_title') }}</h2>
        <p class="lead mb-2 mx-auto" style="max-width: 560px;">{{ __('messages.cta_final_desc') }}</p>
        <p class="small opacity-75 mb-4">{{ __('messages.home_campuses') }} • {{ __('messages.translation_badge') }}</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ url(app()->getLocale() . '/contact') }}" class="btn btn-warning btn-lg px-4 fw-bold">
                {{ __('messages.register_now') }}
            </a>
            <a href="{{ url(app()->getLocale() . '/services') }}" class="btn btn-outline-light btn-lg px-4">
                {{ __('messages.translation_title') }}
            </a>
            <a href="{{ url(app()->getLocale() . '/contact') }}" class="btn btn-light btn-lg px-4 fw-bold text-dark">
                {{ __('messages.free_trial') }}
            </a>
        </div>
    </div>
</section>

<style>
    .program-card, .translate-card, .team-home-card, .partner-home-card { transition: transform .22s ease, box-shadow .22s ease; }
    .team-photo-sm { width: 128px; height: 128px; border-radius: 1rem; overflow: hidden; border: 2px solid #fff; box-shadow: 0 .35rem .9rem rgba(0,0,0,.10); background: #f1f3f5; }
    .team-photo-sm img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s ease; }
    .team-home-card:hover .team-photo-sm img { transform: scale(1.06); }
    .program-card:hover, .translate-card:hover, .team-home-card:hover, .partner-home-card:hover { transform: translateY(-6px); box-shadow: 0 .75rem 1.5rem rgba(0,0,0,.12) !important; }
    /* Hover halus untuk tombol */
    .btn { transition: transform .18s ease, box-shadow .18s ease, filter .18s ease; }
    .btn:hover { transform: translateY(-1px); box-shadow: 0 .4rem .9rem rgba(0,0,0,.14) !important; filter: brightness(1.02); }
    .btn:active { transform: translateY(0); box-shadow: none !important; }
    /* Mobile responsive tweaks */
    @media (max-width: 576px) {
        .hero-premium { padding: 64px 0 56px !important; }
        .hero-premium .display-4 { font-size: 1.9rem; }
        .uni-slider { gap: .75rem !important; }
    }
</style>

@endsection
