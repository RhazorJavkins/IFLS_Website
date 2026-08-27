@extends('layouts.app')

@section('title', __('messages.our_courses'))

@section('content')

<div class="container py-4">
    <div class="row g-4">

        {{-- ===== SIDEBAR NAV (sticky) ===== --}}
        <div class="col-lg-3">
            <nav id="course-sidebar" class="course-sidebar sticky-lg-top pt-3">
                <div class="list-group list-group-flush" id="courses-nav">
                    <a class="list-group-item list-group-item-action border-0 ps-2" href="#overview">
                        <i class="fa-solid fa-circle-info me-2 text-primary"></i>{{ __('messages.our_courses') }}
                    </a>
                    <a class="list-group-item list-group-item-action border-0 ps-2" href="#bahasa-indonesia">
                        🇮🇩 {{ __('messages.prog_indo') }}
                    </a>
                    <a class="list-group-item list-group-item-action border-0 ps-2" href="#mandarin">
                        🇨🇳 {{ __('messages.prog_mandarin') }}
                    </a>
                    <a class="list-group-item list-group-item-action border-0 ps-2" href="#english">
                        🇬🇧 {{ __('messages.prog_english') }}
                    </a>
                </div>
                <hr class="my-3">
                <a href="{{ url(app()->getLocale() . '/contact') }}" class="btn btn-warning w-100 fw-bold">
                    {{ __('messages.register_now') }}
                </a>
            </nav>
        </div>

        {{-- ===== KONTEN ===== --}}
        <div class="col-lg-9">

            {{-- Overview --}}
            <section id="overview" class="py-4">
                <h1 class="fw-bold mb-3">{{ __('messages.our_courses') }}</h1>
                <p class="lead text-muted">{{ __('messages.courses_intro') }}</p>
                <div class="d-flex gap-2 flex-wrap mt-3">
                    <a href="#bahasa-indonesia" class="btn btn-outline-primary btn-sm">🇮🇩 {{ __('messages.prog_indo') }}</a>
                    <a href="#mandarin" class="btn btn-outline-primary btn-sm">🇨🇳 {{ __('messages.prog_mandarin') }}</a>
                    <a href="#english" class="btn btn-outline-primary btn-sm">🇬🇧 {{ __('messages.prog_english') }}</a>
                </div>
            </section>

            <hr class="my-4">

            {{-- ============================================================ --}}
            {{-- PROGRAM 1: BAHASA INDONESIA UNTUK WNA (CORE BUSINESS) --}}
            {{-- ============================================================ --}}
            <section id="bahasa-indonesia" class="py-4 course-section">
                <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                    <h2 class="fw-bold mb-0">🇮🇩 {{ __('messages.prog_indo') }}</h2>
                    <span class="badge bg-danger">{{ __('messages.badge_flagship') }}</span>
                </div>
                <p class="text-muted">{{ __('messages.ci_hero_desc') }}</p>

                {{-- Tingkatan --}}
                <h5 class="fw-bold mt-4"><i class="fa-solid fa-layer-group text-primary me-2"></i>{{ __('messages.levels_title') }}</h5>
                <ul class="nav nav-pills mb-3" id="ci-level-tabs" role="tablist">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#ci-lvl1" type="button">{{ __('messages.ci_lvl1') }}</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#ci-lvl2" type="button">{{ __('messages.ci_lvl2') }}</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#ci-lvl3" type="button">{{ __('messages.ci_lvl3') }}</button></li>
                </ul>
                <div class="tab-content bg-light rounded p-4">
                    <div class="tab-pane fade show active" id="ci-lvl1"><p class="mb-0">{{ __('messages.ci_lvl1_desc') }}</p></div>
                    <div class="tab-pane fade" id="ci-lvl2"><p class="mb-0">{{ __('messages.ci_lvl2_desc') }}</p></div>
                    <div class="tab-pane fade" id="ci-lvl3"><p class="mb-0">{{ __('messages.ci_lvl3_desc') }}</p></div>
                </div>

                {{-- Format --}}
                <h5 class="fw-bold mt-4"><i class="fa-solid fa-display text-primary me-2"></i>{{ __('messages.format_title') }}</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm"><div class="card-body">
                            <h6 class="fw-bold"><i class="fa-solid fa-school text-success me-2"></i>{{ __('messages.format_offline') }}</h6>
                            <p class="mb-0 small text-muted">{{ __('messages.format_offline_desc') }}</p>
                        </div></div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm"><div class="card-body">
                            <h6 class="fw-bold"><i class="fa-solid fa-video text-primary me-2"></i>{{ __('messages.format_online') }}</h6>
                            <p class="mb-0 small text-muted">{{ __('messages.format_online_desc') }}</p>
                        </div></div>
                    </div>
                </div>

                {{-- Tipe layanan --}}
                <h5 class="fw-bold mt-4"><i class="fa-solid fa-handshake text-primary me-2"></i>{{ __('messages.services_type_title') }}</h5>
                <div class="row g-3">
                    @foreach ([['regular','fa-users'],['private','fa-user-check'],['corporate','fa-building']] as $svc)
                        @php $key = $svc[0]; @endphp
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm"><div class="card-body p-3">
                                <h6 class="fw-bold mb-1"><i class="fa-solid {{ $svc[1] }} text-warning me-2"></i>{{ __("messages.svc_type_{$key}") }}
                                    @if($key === 'private' || $key === 'corporate')<span class="badge bg-secondary ms-1">+</span>@endif
                                </h6>
                                <p class="mb-0 small text-muted">{{ __("messages.svc_type_{$key}_desc") }}</p>
                            </div></div>
                        </div>
                    @endforeach
                </div>

                {{-- CTA Bahasa Indonesia — WeChat + WhatsApp (solid) --}}
                <div class="mt-4 p-3 rounded-3 d-flex flex-wrap gap-3 align-items-center justify-content-between shadow-sm" style="background:#B01C1C;">
                    <div class="text-white">
                        <div class="fw-bold"><i class="fa-solid fa-fire me-1"></i> {{ __('messages.prog_indo') }} — {{ __('messages.badge_flagship') }}</div>
                        <div class="small" style="opacity:.85;">{{ __('messages.courses_cta_id_sub') }}</div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light fw-bold px-4 text-dark" data-bs-toggle="modal" data-bs-target="#wechatModal"><i class="fa-brands fa-weixin me-1" style="color:#07C160;"></i> WeChat</button>
                        <a href="https://wa.me/628118887568?text=Halo%20IF%20Language%20School%20-%20Info%20Bahasa%20Indonesia" target="_blank" rel="noopener" class="btn fw-bold px-4 text-white" style="background:#25D366; border-color:#25D366;"><i class="fa-brands fa-whatsapp me-1"></i> WhatsApp</a>
                    </div>
                </div>

                {{-- Program lainnya --}}
                <div class="mt-4 d-flex gap-2 align-items-center flex-wrap">
                    <span class="small text-muted fw-bold">{{ __('messages.other_programs') }}:</span>
                    <a href="#mandarin" class="badge bg-light text-dark text-decoration-none p-2">🇨🇳 {{ __('messages.prog_mandarin') }}</a>
                    <a href="#english" class="badge bg-light text-dark text-decoration-none p-2">🇬🇧 {{ __('messages.prog_english') }}</a>
                </div>
            </section>

            <hr class="my-4">

            {{-- ============================================================ --}}
            {{-- PROGRAM 2: MANDARIN --}}
            {{-- ============================================================ --}}
            <section id="mandarin" class="py-4 course-section">
                <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                    <h2 class="fw-bold mb-0">🇨🇳 {{ __('messages.prog_mandarin') }}</h2>
                    <span class="badge bg-primary">{{ __('messages.badge_online_privat') }}</span>
                </div>
                <p class="text-muted">{{ __('messages.cm_hero_desc') }}</p>

                {{-- Jenjang stepper --}}
                <h5 class="fw-bold mt-4"><i class="fa-solid fa-route text-primary me-2"></i>{{ __('messages.cm_tingkat_title') }}</h5>
                <div class="position-relative ps-4 mandarin-path">
                    @foreach ([[1,'fa-seedling'],[2,'fa-comments'],[3,'fa-briefcase']] as $t)
                        <div class="pb-4 position-relative mandarin-step">
                            <span class="step-dot"><i class="fa-solid {{ $t[1] }}"></i></span>
                            <h6 class="fw-bold mb-1">{{ __("messages.cm_t{$t[0]}") }}</h6>
                            <p class="mb-0 small text-muted">{{ __("messages.cm_t{$t[0]}_desc") }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="alert alert-info d-inline-flex align-items-center gap-2 mt-2 mb-0">
                    <i class="fa-solid fa-bell"></i>
                    <span><strong>{{ __('messages.coming_soon_offline') }}</strong></span>
                </div>
                <div class="mt-3">
                    <span class="badge bg-dark p-2"><i class="fa-solid fa-building me-1"></i>{{ __('messages.svc_type_corporate') }}</span>
                </div>

                {{-- CTA Mandarin — WeChat + WhatsApp (solid) --}}
                <div class="mt-4 p-3 rounded-3 d-flex flex-wrap gap-3 align-items-center justify-content-between shadow-sm" style="background:#1A2A4F;">
                    <div class="text-white">
                        <div class="fw-bold"><i class="fa-solid fa-language me-1"></i> {{ __('messages.prog_mandarin') }} — {{ __('messages.badge_online_privat') }}</div>
                        <div class="small" style="opacity:.85;">{{ __('messages.courses_cta_mandarin_sub') }}</div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light fw-bold px-4 text-dark" data-bs-toggle="modal" data-bs-target="#wechatModal"><i class="fa-brands fa-weixin me-1" style="color:#07C160;"></i> WeChat</button>
                        <a href="https://wa.me/628118887568?text=Halo%20IF%20Language%20School%20-%20Info%20Mandarin" target="_blank" rel="noopener" class="btn fw-bold px-4 text-white" style="background:#25D366; border-color:#25D366;"><i class="fa-brands fa-whatsapp me-1"></i> WhatsApp</a>
                    </div>
                </div>

                {{-- Program lainnya --}}
                <div class="mt-4 d-flex gap-2 align-items-center flex-wrap">
                    <span class="small text-muted fw-bold">{{ __('messages.other_programs') }}:</span>
                    <a href="#bahasa-indonesia" class="badge bg-light text-dark text-decoration-none p-2">🇮🇩 {{ __('messages.prog_indo') }}</a>
                    <a href="#english" class="badge bg-light text-dark text-decoration-none p-2">🇬🇧 {{ __('messages.prog_english') }}</a>
                </div>
            </section>

            <hr class="my-4">

            {{-- ============================================================ --}}
            {{-- PROGRAM 3: ENGLISH --}}
            {{-- ============================================================ --}}
            <section id="english" class="py-4 course-section">
                <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                    <h2 class="fw-bold mb-0">🇬🇧 {{ __('messages.prog_english') }}</h2>
                    <span class="badge bg-success">{{ __('messages.badge_small_class') }}</span>
                </div>
                <p class="text-muted">{{ __('messages.ce_hero_desc') }}</p>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold"><i class="fa-solid fa-chart-simple text-success me-2"></i>{{ __('messages.ce_placement_title') }}</h5>
                        <p class="mb-0 text-muted">{{ __('messages.ce_placement_desc') }}</p>
                    </div>
                </div>

                {{-- CTA English — WeChat + WhatsApp (solid) --}}
                <div class="mt-4 p-3 rounded-3 d-flex flex-wrap gap-3 align-items-center justify-content-between shadow-sm" style="background:#1B4332;">
                    <div class="text-white">
                        <div class="fw-bold"><i class="fa-solid fa-graduation-cap me-1"></i> {{ __('messages.prog_english') }} — {{ __('messages.badge_small_class') }}</div>
                        <div class="small" style="opacity:.85;">{{ __('messages.courses_cta_english_sub') }}</div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light fw-bold px-4 text-dark" data-bs-toggle="modal" data-bs-target="#wechatModal"><i class="fa-brands fa-weixin me-1" style="color:#07C160;"></i> WeChat</button>
                        <a href="https://wa.me/628118887568?text=Halo%20IF%20Language%20School%20-%20Info%20English%20Class" target="_blank" rel="noopener" class="btn fw-bold px-4 text-white" style="background:#25D366; border-color:#25D366;"><i class="fa-brands fa-whatsapp me-1"></i> WhatsApp</a>
                    </div>
                </div>

                {{-- Program lainnya --}}
                <div class="mt-4 d-flex gap-2 align-items-center flex-wrap">
                    <span class="small text-muted fw-bold">{{ __('messages.other_programs') }}:</span>
                    <a href="#bahasa-indonesia" class="badge bg-light text-dark text-decoration-none p-2">🇮🇩 {{ __('messages.prog_indo') }}</a>
                    <a href="#mandarin" class="badge bg-light text-dark text-decoration-none p-2">🇨🇳 {{ __('messages.prog_mandarin') }}</a>
                </div>
            </section>

            <hr class="my-4">

            {{-- CTA akhir --}}
            <section class="py-4 text-white rounded-3 px-4 text-center" style="background: linear-gradient(135deg, #1a2a4f 0%, #2d4a7a 100%);">
                <h4 class="fw-bold mb-2">{{ __('messages.cta_final_title') }}</h4>
                <p class="mb-3">{{ __('messages.cta_final_desc') }}</p>
                <a href="{{ url(app()->getLocale() . '/contact') }}" class="btn btn-warning fw-bold px-4">{{ __('messages.register_now') }}</a>
            </section>

            <div class="text-center py-3">
                <a href="#overview" class="btn btn-link btn-sm text-decoration-none"><i class="fa-solid fa-arrow-up me-1"></i>{{ __('messages.back_to_top_courses') }}</a>
            </div>
        </div>
    </div>
</div>

{{-- ===== WeChat QR Modal (pop-out) ===== --}}
<div class="modal fade" id="wechatModal" tabindex="-1" aria-labelledby="wechatModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header border-0 pb-0" style="background:#07C160;">
        <h5 class="modal-title text-white fw-bold" id="wechatModalLabel"><i class="fa-brands fa-weixin me-2"></i> WeChat — IF Language School</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-4">
        <div class="bg-white border rounded-3 p-3 d-inline-block shadow-sm mb-3">
          <img src="https://placehold.co/240x240/07C160/FFFFFF?text=WeChat+QR" alt="WeChat QR" class="img-fluid rounded-2" style="width:240px; height:240px; object-fit:contain;">
        </div>
        <h6 class="fw-bold mb-1">Scan untuk Hubungi Kami</h6>
        <p class="small text-muted mb-2">Buka WeChat → Scan QR di atas</p>
        <div class="bg-light rounded-3 p-2 small">
          <div class="fw-bold" style="color:#07C160;"><i class="fa-solid fa-qrcode me-1"></i> ID: IFLanguageSchool</div>
          <div class="text-muted" style="font-size:.75rem;">Atau cari ID di WeChat • Balas cepat di jam kerja</div>
        </div>
        <div class="d-grid gap-2 mt-3">
          <a href="https://wa.me/628118887568?text=Halo%20IF%20Language%20School" target="_blank" class="btn fw-bold text-white" style="background:#25D366; border-color:#25D366;"><i class="fa-brands fa-whatsapp me-1"></i> Atau chat WhatsApp</a>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
        <p class="small text-muted mt-2 mb-0" style="font-size:.70rem;">Ganti QR placeholder di <code>public/images/wechat-qr.png</code></p>
      </div>
    </div>
  </div>
</div>

<style>
    .course-sidebar { top: 90px; }
    #courses-nav .list-group-item { font-size: .95rem; }
    html { scroll-behavior: smooth; }
    section[id] { scroll-margin-top: 80px; }

    /* Mandarin stepper */
    .mandarin-path::before {
        content: ''; position: absolute; left: 15px; top: 8px; bottom: 24px;
        width: 3px; background: linear-gradient(#b03a3a, #2d4a7a); border-radius: 2px;
    }
    .mandarin-step:last-child { padding-bottom: 0; }
    .step-dot {
        position: absolute; left: -32px; top: 0;
        width: 34px; height: 34px; border-radius: 50%;
        background: #fff; border: 3px solid #2d4a7a;
        display: inline-flex; align-items: center; justify-content: center;
        color: #2d4a7a; font-size: .85rem;
    }
</style>

{{-- ScrollSpy Bootstrap --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const main = document.querySelector('main');
        if (main && window.bootstrap) {
            new bootstrap.ScrollSpy(main, {
                target: '#courses-nav',
                rootMargin: '-20% 0px -70% 0px'
            });
        }
    });
</script>

@endsection
