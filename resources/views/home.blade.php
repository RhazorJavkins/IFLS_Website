@extends('layouts.app')

@section('title', __('messages.welcome_title'))

@section('content')

{{-- ===== 1. HERO — sinkron dengan 3 kota + terjemahan ===== --}}
<section class="hero-section text-white text-center position-relative overflow-hidden" style="background: linear-gradient(135deg, #1a2a4f 0%, #2d4a7a 60%, #b03a3a 100%); padding: 110px 0 90px;">
    <div class="container position-relative" style="z-index:2;">
        @if(!empty(__('messages.hero_badge')))
            <span class="badge bg-light text-dark mb-3 px-3 py-2 shadow-sm">{{ __('messages.hero_badge') }}</span>
        @endif
        <h1 class="display-3 fw-bold mb-3" style="line-height:1.1;">{{ __('messages.welcome_title') }}</h1>
        <p class="lead mb-2 mx-auto" style="max-width: 640px;">{{ __('messages.welcome_subtitle') }}</p>
        <p class="small mb-1 opacity-75">{{ __('messages.home_campuses') }}</p>
        <p class="small mb-4 opacity-75"><i class="fa-solid fa-language me-1"></i> {{ __('messages.home_hero_extra') }}</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ url(app()->getLocale() . '/contact') }}" class="btn btn-warning btn-lg px-4 fw-bold shadow">
                {{ __('messages.register_now') }}
            </a>
            <a href="{{ url(app()->getLocale() . '/courses') }}" class="btn btn-outline-light btn-lg px-4">
                {{ __('messages.hero_cta_courses') }}
            </a>
            <a href="{{ url(app()->getLocale() . '/services') }}" class="btn btn-light btn-lg px-4 fw-bold text-dark">
                <i class="fa-solid fa-language me-1 text-primary"></i> {{ __('messages.services') }}
            </a>
        </div>
        <div class="d-flex gap-2 justify-content-center flex-wrap mt-4 small opacity-75">
            <span><i class="fa-solid fa-map-pin me-1 text-warning"></i> PIK • Central Park • Serpong</span>
            <span class="d-none d-md-inline">•</span>
            <span><i class="fa-solid fa-map-pin me-1 text-warning"></i> Semarang • Surabaya</span>
            <span class="d-none d-md-inline">•</span>
            <span><i class="fa-solid fa-video me-1 text-warning"></i> Online Live</span>
        </div>
    </div>
    <div class="position-absolute" style="right:-60px; top:-60px; width:320px; height:320px; background: radial-gradient(circle, rgba(255,255,255,.10) 0%, transparent 70%); border-radius:50%;"></div>
</section>

{{-- ===== 2. STATS STRIP ===== --}}
<section class="py-5 bg-light border-bottom">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-6 col-md-4">
                <h2 class="display-5 fw-bold text-primary mb-1">20,000+</h2>
                <p class="text-muted mb-0">{{ __('messages.stat_students') }}</p>
            </div>
            <div class="col-6 col-md-4">
                <h2 class="display-5 fw-bold text-primary mb-1">2019</h2>
                <p class="text-muted mb-0">{{ __('messages.stat_years') }}</p>
            </div>
            <div class="col-6 col-md-4 mx-auto">
                <h2 class="display-5 fw-bold text-primary mb-1">50+</h2>
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
        </div>
        <div class="row g-4">
            @foreach ([1, 2, 3] as $i)
                <div class="col-md-4 text-center">
                    <div class="display-6 mb-2">
                        @if($i === 1)<i class="fa-solid fa-certificate text-warning"></i>
                        @elseif($i === 2)<i class="fa-solid fa-users text-primary"></i>
                        @else<i class="fa-solid fa-clock text-success"></i>@endif
                    </div>
                    <h5 class="fw-bold">{{ __("messages.why_{$i}_title") }}</h5>
                    <p class="text-muted small">{{ __("messages.why_{$i}_desc") }}</p>
                </div>
            @endforeach
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
            {{-- Direksi highlight --}}
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3 team-home-card">
                    <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width:64px;height:64px; background: linear-gradient(135deg, #1a2a4f, #b03a3a);">易</div>
                    <h6 class="fw-bold mb-0 small">易衍 YI YAN</h6>
                    <div class="small text-muted" style="font-size:.72rem;">董事长 Chairman</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3 team-home-card">
                    <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width:64px;height:64px; background: linear-gradient(135deg, #7a5200, #d4a017);">刘</div>
                    <h6 class="fw-bold mb-0 small">刘裕洁 Amber</h6>
                    <div class="small text-muted" style="font-size:.72rem;">Director</div>
                </div>
            </div>
            @php
                $homeTeam = [
                    ['玉雪慧', 'Xiao Yu', 'General Manager', '#1a2a4f'],
                    ['潘炫颖', 'Novi', 'Training Director', '#b03a3a'],
                    ['洪莉莎', 'Elissa', 'Curriculum Supervisor', '#2d6a4f'],
                    ['李美慧', 'Susanty', 'Academic Supervisor', '#7a5200'],
                ];
            @endphp
            @foreach($homeTeam as $m)
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3 team-home-card">
                        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center text-white small fw-bold" style="width:64px;height:64px; background: {{ $m[3] }};">
                            {{ mb_substr($m[0],0,1) }}
                        </div>
                        <h6 class="fw-bold mb-0 small">{{ $m[0] }} <span class="fw-normal text-muted">{{ $m[1] }}</span></h6>
                        <div class="small text-muted" style="font-size:.70rem;">{{ $m[2] }}</div>
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
        <div class="row g-4">
            @foreach ([1, 2, 3] as $i)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-2 text-warning">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            </div>
                            <p class="card-text fst-italic">“{{ __("messages.testimonial{$i}") }}”</p>
                            <p class="mb-0 fw-bold small">{{ __("messages.testimonial{$i}_name") }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== 9. CTA AKHIR — sinkron ===== --}}
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
    .program-card:hover, .translate-card:hover, .team-home-card:hover, .partner-home-card:hover { transform: translateY(-6px); box-shadow: 0 .75rem 1.5rem rgba(0,0,0,.12) !important; }
</style>

@endsection
