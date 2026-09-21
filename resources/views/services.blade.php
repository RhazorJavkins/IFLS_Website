@extends('layouts.app')

@section('title', __('messages.translation_title') . ' — IF Language School')

@section('content')

{{-- ===== HERO TERJEMAHAN ===== --}}
<section class="hero-translation text-white" style="background: linear-gradient(135deg, #1a2a4f 0%, #2d4a7a 55%, #b03a3a 100%); padding: 90px 0 80px;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="badge bg-white text-dark mb-3 px-3 py-2 fw-semibold" style="letter-spacing:.5px; font-size:.78rem;">
                    <i class="fa-solid fa-award me-1 text-primary"></i> {{ __('messages.translation_badge') }}
                </span>
                <h1 class="display-4 fw-bold mb-3" style="line-height:1.15;">
                    {{ __('messages.translation_title') }}
                    <span class="d-block" style="color:#FFD166;">{{ __('messages.translation_title_accent') }}</span>
                </h1>
                <p class="lead mb-4 opacity-90" style="max-width: 560px;">
                    {{ __('messages.translation_subtitle') }}
                </p>
                <p class="mb-4 text-white-50" style="max-width:560px; font-size:.95rem;">
                    {{ __('messages.translation_intro') }}
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ url(app()->getLocale() . '/contact') }}" class="btn btn-warning btn-lg px-4 fw-bold shadow">
                        <i class="fa-brands fa-whatsapp me-1"></i> {{ __('messages.translation_cta_consult') }}
                    </a>
                    <a href="#layanan" class="btn btn-outline-light btn-lg px-4">
                        {{ __('messages.translation_cta_explore') }} <i class="fa-solid fa-arrow-down ms-1"></i>
                    </a>
                </div>
                <div class="d-flex gap-4 mt-4 flex-wrap text-white-50 small">
                    <span><i class="fa-solid fa-check-circle text-warning me-1"></i> {{ __('messages.translation_trust_1') }}</span>
                    <span><i class="fa-solid fa-check-circle text-warning me-1"></i> {{ __('messages.translation_trust_2') }}</span>
                    <span><i class="fa-solid fa-check-circle text-warning me-1"></i> {{ __('messages.translation_trust_3') }}</span>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="bg-white rounded-4 p-4 shadow-lg text-dark position-relative" style="transform: rotate(-1deg);">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                            <i class="fa-solid fa-language text-primary fa-lg"></i>
                        </div>
                        <div>
                            <div class="fw-bold">ID ⇄ CN ⇄ EN</div>
                            <div class="small text-muted">Indonesia • Mandarin • Inggris</div>
                        </div>
                        <span class="badge bg-success ms-auto">Tersumpah</span>
                    </div>
                    <div class="bg-light rounded-3 p-3 mb-3">
                        <div class="small text-muted mb-1">Contoh hasil</div>
                        <div class="fw-semibold small">合同翻译 / Contract Translation</div>
                        <div class="progress mt-2" style="height:6px;">
                            <div class="progress-bar bg-success" style="width: 92%"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mt-1">
                            <span>Akurasi 99.2%</span><span>2.400+ proyek</span>
                        </div>
                    </div>
                    <div class="row g-2 text-center small">
                        <div class="col-4">
                            <div class="bg-primary bg-opacity-10 rounded-3 py-2">
                                <div class="fw-bold text-primary">24J</div>
                                <div class="text-muted" style="font-size:.7rem;">Express</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-warning bg-opacity-15 rounded-3 py-2">
                                <div class="fw-bold" style="color:#7a5200;">100%</div>
                                <div class="text-muted" style="font-size:.7rem;">Rahasia</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-success bg-opacity-10 rounded-3 py-2">
                                <div class="fw-bold text-success">Gratis</div>
                                <div class="text-muted" style="font-size:.7rem;">Revisi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== STAT STRIP ===== --}}
<section class="py-4 bg-white border-bottom">
    <div class="container">
        <div class="row text-center g-3">
            <div class="col-6 col-md-3">
                <div class="fw-bold h4 mb-0 text-primary">20.000+</div>
                <div class="small text-muted">{{ __('messages.translation_stat_docs') }}</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="fw-bold h4 mb-0 text-primary">1.200+</div>
                <div class="small text-muted">{{ __('messages.translation_stat_clients') }}</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="fw-bold h4 mb-0 text-primary">50+</div>
                <div class="small text-muted">{{ __('messages.translation_stat_fields') }}</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="fw-bold h4 mb-0 text-primary">98%</div>
                <div class="small text-muted">{{ __('messages.translation_stat_satisfaction') }}</div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 4 LAYANAN UTAMA ===== --}}
<section id="layanan" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3 fw-semibold">{{ __('messages.translation_services_badge') }}</span>
            <h2 class="fw-bold mb-2">{{ __('messages.translation_services_title') }}</h2>
            <p class="text-muted mx-auto" style="max-width:640px;">{{ __('messages.translation_services_desc') }}</p>
        </div>

        <div class="row g-4">
            {{-- 1. Terjemahan Dokumen --}}
            <div class="col-md-6 col-xl-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden service-card">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <div class="icon-wrap bg-primary bg-opacity-10 text-primary">
                            <i class="fa-solid fa-file-lines fa-lg"></i>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary mt-3">{{ __('messages.svc_doc_badge') }}</span>
                        <h3 class="h5 fw-bold mt-2 mb-1">{{ __('messages.svc_doc_title') }}</h3>
                        <p class="small text-muted mb-0">{{ __('messages.svc_doc_desc') }}</p>
                    </div>
                    <div class="card-body px-4 pt-3">
                        <ul class="list-unstyled small mb-3">
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>{{ __('messages.svc_doc_f1') }}</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>{{ __('messages.svc_doc_f2') }}</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>{{ __('messages.svc_doc_f3') }}</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>{{ __('messages.svc_doc_f4') }}</li>
                        </ul>
                        <div class="bg-light rounded-3 p-2 small text-muted">
                            <i class="fa-solid fa-tags me-1 text-primary"></i> {{ __('messages.svc_doc_examples') }}
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
                        <a href="{{ url(app()->getLocale() . '/contact') }}" class="btn btn-primary w-100 fw-semibold">
                            {{ __('messages.translation_btn_quote') }} <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                        <div class="text-center small text-muted mt-2"><i class="fa-regular fa-clock me-1"></i> {{ __('messages.svc_doc_eta') }}</div>
                    </div>
                </div>
            </div>

            {{-- 2. Terjemahan Tersumpah --}}
            <div class="col-md-6 col-xl-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden service-card featured">
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-warning text-dark shadow-sm"><i class="fa-solid fa-star me-1"></i> {{ __('messages.svc_sworn_popular') }}</span>
                    </div>
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <div class="icon-wrap bg-warning bg-opacity-20" style="color:#7a5200;">
                            <i class="fa-solid fa-certificate fa-lg"></i>
                        </div>
                        <span class="badge bg-warning bg-opacity-20 mt-3" style="color:#7a5200;">{{ __('messages.svc_sworn_badge') }}</span>
                        <h3 class="h5 fw-bold mt-2 mb-1">{{ __('messages.svc_sworn_title') }}</h3>
                        <p class="small text-muted mb-0">{{ __('messages.svc_sworn_desc') }}</p>
                    </div>
                    <div class="card-body px-4 pt-3">
                        <ul class="list-unstyled small mb-3">
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>{{ __('messages.svc_sworn_f1') }}</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>{{ __('messages.svc_sworn_f2') }}</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>{{ __('messages.svc_sworn_f3') }}</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>{{ __('messages.svc_sworn_f4') }}</li>
                        </ul>
                        <div class="bg-warning bg-opacity-10 rounded-3 p-2 small" style="color:#5a3e00;">
                            <i class="fa-solid fa-shield-halved me-1"></i> {{ __('messages.svc_sworn_examples') }}
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
                        <a href="{{ url(app()->getLocale() . '/contact') }}" class="btn btn-warning w-100 fw-bold text-dark">
                            {{ __('messages.translation_btn_quote') }} <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                        <div class="text-center small text-muted mt-2"><i class="fa-solid fa-stamp me-1"></i> {{ __('messages.svc_sworn_eta') }}</div>
                    </div>
                </div>
            </div>

            {{-- 3. Video Translation --}}
            <div class="col-md-6 col-xl-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden service-card">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <div class="icon-wrap" style="background:#ffe8e8; color:#b03a3a;">
                            <i class="fa-solid fa-closed-captioning fa-lg"></i>
                        </div>
                        <span class="badge mt-3" style="background:#ffe8e8; color:#b03a3a;">{{ __('messages.svc_video_badge') }}</span>
                        <h3 class="h5 fw-bold mt-2 mb-1">{{ __('messages.svc_video_title') }}</h3>
                        <p class="small text-muted mb-0">{{ __('messages.svc_video_desc') }}</p>
                    </div>
                    <div class="card-body px-4 pt-3">
                        <ul class="list-unstyled small mb-3">
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>{{ __('messages.svc_video_f1') }}</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>{{ __('messages.svc_video_f2') }}</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>{{ __('messages.svc_video_f3') }}</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>{{ __('messages.svc_video_f4') }}</li>
                        </ul>
                        <div class="bg-light rounded-3 p-2 small text-muted">
                            <i class="fa-solid fa-film me-1" style="color:#b03a3a;"></i> {{ __('messages.svc_video_examples') }}
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
                        <a href="{{ url(app()->getLocale() . '/contact') }}" class="btn btn-dark w-100 fw-semibold">
                            {{ __('messages.translation_btn_quote') }} <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                        <div class="text-center small text-muted mt-2"><i class="fa-solid fa-clapperboard me-1"></i> {{ __('messages.svc_video_eta') }}</div>
                    </div>
                </div>
            </div>

            {{-- 4. Layanan Interpreter --}}
            <div class="col-md-6 col-xl-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden service-card">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <div class="icon-wrap bg-success bg-opacity-10 text-success">
                            <i class="fa-solid fa-comments fa-lg"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success mt-3">{{ __('messages.svc_interp_badge') }}</span>
                        <h3 class="h5 fw-bold mt-2 mb-1">{{ __('messages.svc_interp_title') }}</h3>
                        <p class="small text-muted mb-0">{{ __('messages.svc_interp_desc') }}</p>
                    </div>
                    <div class="card-body px-4 pt-3">
                        <ul class="list-unstyled small mb-3">
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>{{ __('messages.svc_interp_f1') }}</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>{{ __('messages.svc_interp_f2') }}</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>{{ __('messages.svc_interp_f3') }}</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>{{ __('messages.svc_interp_f4') }}</li>
                        </ul>
                        <div class="bg-success bg-opacity-10 rounded-3 p-2 small text-success">
                            <i class="fa-solid fa-headset me-1"></i> {{ __('messages.svc_interp_examples') }}
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
                        <a href="{{ url(app()->getLocale() . '/contact') }}" class="btn btn-success w-100 fw-semibold">
                            {{ __('messages.translation_btn_quote') }} <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                        <div class="text-center small text-muted mt-2"><i class="fa-solid fa-calendar-check me-1"></i> {{ __('messages.svc_interp_eta') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== ALUR KERJA ===== --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <span class="badge bg-dark text-white px-3 py-2 mb-3">{{ __('messages.translation_process_badge') }}</span>
                <h2 class="fw-bold mb-3">{{ __('messages.translation_process_title') }}</h2>
                <p class="text-muted mb-4">{{ __('messages.translation_process_desc') }}</p>
                <a href="{{ url(app()->getLocale() . '/contact') }}" class="btn btn-primary px-4">
                    {{ __('messages.translation_btn_start') }} <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    @php
                        $steps = [
                            ['n'=>'01', 'icon'=>'fa-comments', 'title'=>__('messages.step_1_title'), 'desc'=>__('messages.step_1_desc'), 'color'=>'#1a2a4f'],
                            ['n'=>'02', 'icon'=>'fa-file-invoice-dollar', 'title'=>__('messages.step_2_title'), 'desc'=>__('messages.step_2_desc'), 'color'=>'#2d4a7a'],
                            ['n'=>'03', 'icon'=>'fa-pen-ruler', 'title'=>__('messages.step_3_title'), 'desc'=>__('messages.step_3_desc'), 'color'=>'#b03a3a'],
                            ['n'=>'04', 'icon'=>'fa-box-open', 'title'=>__('messages.step_4_title'), 'desc'=>__('messages.step_4_desc'), 'color'=>'#2d6a4f'],
                        ];
                    @endphp
                    @foreach($steps as $st)
                        <div class="col-6">
                            <div class="border rounded-4 p-4 h-100 position-relative bg-light">
                                <div class="position-absolute top-0 end-0 mt-3 me-3 fw-bold opacity-10" style="font-size:2.2rem; color:{{ $st['color'] }};">{{ $st['n'] }}</div>
                                <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:44px;height:44px; background: {{ $st['color'] }}15; color: {{ $st['color'] }};">
                                    <i class="fa-solid {{ $st['icon'] }}"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ $st['title'] }}</h6>
                                <p class="small text-muted mb-0">{{ $st['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== KEUNGGULAN ===== --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h3 class="fw-bold">{{ __('messages.translation_why_title') }}</h3>
            <p class="text-muted">{{ __('messages.translation_why_desc') }}</p>
        </div>
        <div class="row g-4">
            <div class="col-md-3 col-6 text-center">
                <div class="bg-white rounded-4 p-4 shadow-sm h-100">
                    <i class="fa-solid fa-user-graduate text-primary fa-2x mb-3"></i>
                    <h6 class="fw-bold mb-1">{{ __('messages.why_t1_title') }}</h6>
                    <p class="small text-muted mb-0">{{ __('messages.why_t1_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center">
                <div class="bg-white rounded-4 p-4 shadow-sm h-100">
                    <i class="fa-solid fa-lock text-success fa-2x mb-3"></i>
                    <h6 class="fw-bold mb-1">{{ __('messages.why_t2_title') }}</h6>
                    <p class="small text-muted mb-0">{{ __('messages.why_t2_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center">
                <div class="bg-white rounded-4 p-4 shadow-sm h-100">
                    <i class="fa-solid fa-stopwatch text-warning fa-2x mb-3"></i>
                    <h6 class="fw-bold mb-1">{{ __('messages.why_t3_title') }}</h6>
                    <p class="small text-muted mb-0">{{ __('messages.why_t3_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center">
                <div class="bg-white rounded-4 p-4 shadow-sm h-100">
                    <i class="fa-solid fa-rotate text-danger fa-2x mb-3"></i>
                    <h6 class="fw-bold mb-1">{{ __('messages.why_t4_title') }}</h6>
                    <p class="small text-muted mb-0">{{ __('messages.why_t4_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== BAHASA & DOKUMEN ===== --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="rounded-4 p-4 p-md-5" style="background: linear-gradient(135deg, #0f1e3a 0%, #1a2a4f 60%, #2d4a7a 100%);">
            <div class="row align-items-center g-4 text-white">
                <div class="col-lg-7">
                    <h3 class="fw-bold mb-3">{{ __('messages.lang_pair_title') }}</h3>
                    <p class="opacity-75 mb-4">{{ __('messages.lang_pair_desc') }}</p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-white text-dark px-3 py-2">🇮🇩 Indonesia → 中文</span>
                        <span class="badge bg-white text-dark px-3 py-2">中文 → 🇮🇩 Indonesia</span>
                        <span class="badge bg-white text-dark px-3 py-2">🇬🇧 English ⇄ 🇮🇩</span>
                        <span class="badge bg-white text-dark px-3 py-2">中文 ⇄ 🇬🇧 English</span>
                        <span class="badge bg-warning text-dark px-3 py-2">+ {{ __('messages.lang_pair_more') }}</span>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="bg-white rounded-4 p-4 text-dark">
                        <h6 class="fw-bold mb-3"><i class="fa-solid fa-folder-open text-primary me-2"></i>{{ __('messages.supported_docs_title') }}</h6>
                        <div class="row g-2 small">
                            <div class="col-6"><i class="fa-solid fa-file text-primary me-1"></i> {{ __('messages.doc_1') }}</div>
                            <div class="col-6"><i class="fa-solid fa-file text-primary me-1"></i> {{ __('messages.doc_2') }}</div>
                            <div class="col-6"><i class="fa-solid fa-file text-primary me-1"></i> {{ __('messages.doc_3') }}</div>
                            <div class="col-6"><i class="fa-solid fa-file text-primary me-1"></i> {{ __('messages.doc_4') }}</div>
                            <div class="col-6"><i class="fa-solid fa-file text-primary me-1"></i> {{ __('messages.doc_5') }}</div>
                            <div class="col-6"><i class="fa-solid fa-file text-primary me-1"></i> {{ __('messages.doc_6') }}</div>
                            <div class="col-6"><i class="fa-solid fa-file-video text-danger me-1"></i> Video & Subtitle</div>
                            <div class="col-6"><i class="fa-solid fa-file-audio text-success me-1"></i> Audio & Transkrip</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CTA AKHIR ===== --}}
<section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #b03a3a 0%, #7a1f1f 100%);">
    <div class="container py-2">
        <h2 class="fw-bold mb-3">{{ __('messages.translation_cta_title') }}</h2>
        <p class="lead opacity-90 mb-4 mx-auto" style="max-width:640px;">{{ __('messages.translation_cta_desc') }}</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ url(app()->getLocale() . '/contact') }}" class="btn btn-light btn-lg px-4 fw-bold text-dark">
                <i class="fa-brands fa-whatsapp me-1 text-success"></i> {{ __('messages.translation_cta_whatsapp') }}
            </a>
            <a href="{{ url(app()->getLocale() . '/contact') }}" class="btn btn-outline-light btn-lg px-4">
                {{ __('messages.translation_cta_email') }} <i class="fa-solid fa-envelope ms-1"></i>
            </a>
        </div>
        <div class="small opacity-75 mt-3">{{ __('messages.translation_cta_note') }}</div>
    </div>
</section>

<style>
    .service-card { transition: transform .22s ease, box-shadow .22s ease; }
    .service-card:hover { transform: translateY(-6px); box-shadow: 0 1rem 2rem rgba(0,0,0,.13) !important; }
    .service-card.featured { border: 2px solid #FFD166 !important; }
    .icon-wrap { width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; }
    .hero-translation { position:relative; overflow:hidden; }
    .hero-translation::after { content:""; position:absolute; right:-80px; top:-80px; width:360px; height:360px; background: radial-gradient(circle, rgba(255,255,255,.12) 0%, transparent 70%); border-radius:50%; }
</style>

@endsection
