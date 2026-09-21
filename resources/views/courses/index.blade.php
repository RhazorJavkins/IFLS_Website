@extends('layouts.app')

@section('title', __('messages.our_courses'))

@section('content')
@php
    // DB-first: program dikelola via /admin; fallback ke data lang bila DB kosong.
    // Struktur fallback meniru bentuk Program + ProgramFeature (object-based) agar
    // satu loop render dipakai untuk kedua sumber.
    if ($dbPrograms->isNotEmpty()) {
        $programs = $dbPrograms;
    } else {
        $fallback = [
            ['slug'=>'bahasa-indonesia','emoji'=>'🇮🇩','badgeKey'=>'badge_flagship','introKey'=>'ci_hero_desc','color'=>'#B01C1C','style'=>'tabs','flagship'=>true,'soon'=>false,'ctaKey'=>'courses_cta_id_sub','wa'=>'Halo IF Language School - Info Bahasa Indonesia','nameKey'=>'prog_indo',
             'meta'=>['level'=>['t'=>'levels_title','i'=>'fa-layer-group'],'format'=>['t'=>'format_title','i'=>'fa-display'],'service_type'=>['t'=>'services_type_title','i'=>'fa-handshake']],
             'groups'=>['level'=>[['tk'=>'ci_lvl1','dk'=>'ci_lvl1_desc','i'=>null,'b'=>null],['tk'=>'ci_lvl2','dk'=>'ci_lvl2_desc','i'=>null,'b'=>null],['tk'=>'ci_lvl3','dk'=>'ci_lvl3_desc','i'=>null,'b'=>null]],'format'=>[['tk'=>'format_offline','dk'=>'format_offline_desc','i'=>'fa-school','b'=>null],['tk'=>'format_online','dk'=>'format_online_desc','i'=>'fa-video','b'=>null]],'service_type'=>[['tk'=>'svc_type_regular','dk'=>'svc_type_regular_desc','i'=>'fa-users','b'=>null],['tk'=>'svc_type_private','dk'=>'svc_type_private_desc','i'=>'fa-user-check','b'=>'+'],['tk'=>'svc_type_corporate','dk'=>'svc_type_corporate_desc','i'=>'fa-building','b'=>'+']]]],
            ['slug'=>'mandarin','emoji'=>'🇨🇳','badgeKey'=>'badge_online_privat','introKey'=>'cm_hero_desc','color'=>'#1A2A4F','style'=>'stepper','flagship'=>false,'soon'=>true,'ctaKey'=>'courses_cta_mandarin_sub','wa'=>'Halo IF Language School - Info Mandarin','nameKey'=>'prog_mandarin',
             'meta'=>['tier'=>['t'=>'cm_tingkat_title','i'=>'fa-route']],
             'groups'=>['tier'=>[['tk'=>'cm_t1','dk'=>'cm_t1_desc','i'=>'fa-seedling','b'=>null],['tk'=>'cm_t2','dk'=>'cm_t2_desc','i'=>'fa-comments','b'=>null],['tk'=>'cm_t3','dk'=>'cm_t3_desc','i'=>'fa-briefcase','b'=>null]]]],
            ['slug'=>'english','emoji'=>'🇬🇧','badgeKey'=>'badge_small_class','introKey'=>'ce_hero_desc','color'=>'#1B4332','style'=>'cards','flagship'=>false,'soon'=>false,'ctaKey'=>'courses_cta_english_sub','wa'=>'Halo IF Language School - Info English Class','nameKey'=>'prog_english',
             'meta'=>['highlight'=>['t'=>'ce_placement_title','i'=>'fa-chart-simple']],
             'groups'=>['highlight'=>[['tk'=>'ce_placement_title','dk'=>'ce_placement_desc','i'=>'fa-chart-simple','b'=>null]]]],
        ];
        $programs = collect($fallback)->map(fn ($p) => (object) [
            'slug' => $p['slug'],
            'emoji' => $p['emoji'],
            'color' => $p['color'],
            'display_style' => $p['style'],
            'is_flagship' => $p['flagship'],
            'show_coming_soon' => $p['soon'],
            'wa_prefill' => $p['wa'],
            'translated_name' => __("messages.{$p['nameKey']}"),
            'translated_badge' => __("messages.{$p['badgeKey']}"),
            'translated_intro' => __("messages.{$p['introKey']}"),
            'translated_cta_text' => __("messages.{$p['ctaKey']}"),
            'group_meta' => collect($p['meta'])->map(fn ($m) => ['title' => __('messages.' . $m['t']), 'icon' => $m['i']])->all(),
            // Flat list of feature objects (dikelompokkan lagi via groupBy->group di renderer)
            'features' => collect($p['groups'])->flatMap(fn ($items, $g) => collect($items)->map(fn ($f) => (object) [
                'group' => $g, 'icon' => $f['i'], 'badge' => $f['b'],
                'translated_title' => __("messages.{$f['tk']}"),
                'translated_description' => __("messages.{$f['dk']}"),
            ]))->values(),
        ]);
    }

    $pricingPlans = $dbPricingPlans->isNotEmpty()
        ? $dbPricingPlans
        : collect([['fa-users','pricing_group','pricing_group_price','text-primary'],['fa-user-check','pricing_private','pricing_private_price','text-success'],['fa-building','pricing_corporate','pricing_corporate_price','text-warning']])
            ->map(fn ($p) => (object) [
                'icon' => $p[0],
                'color' => $p[3],
                'translated_name' => __("messages.{$p[1]}"),
                'translated_price_note' => __("messages.{$p[2]}"),
            ]);
@endphp

<div class="container py-4">
    <div class="row g-4">

        {{-- ===== SIDEBAR NAV (sticky) ===== --}}
        <div class="col-lg-3">
            <nav id="course-sidebar" class="course-sidebar sticky-lg-top pt-3">
                <div class="list-group list-group-flush" id="courses-nav">
                    <a class="list-group-item list-group-item-action border-0 ps-2" href="#overview">
                        <i class="fa-solid fa-circle-info me-2 text-primary"></i>{{ __('messages.our_courses') }}
                    </a>
                    @foreach ($programs as $program)
                        <a class="list-group-item list-group-item-action border-0 ps-2" href="#{{ $program->slug }}">
                            {{ $program->emoji }} {{ $program->translated_name }}
                        </a>
                    @endforeach
                </div>
                <hr class="my-3">
                <a href="{{ route('contact', app()->getLocale()) }}" class="btn btn-warning w-100 fw-bold">
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
                    @foreach ($programs as $program)
                        <a href="#{{ $program->slug }}" class="btn btn-outline-primary btn-sm">{{ $program->emoji }} {{ $program->translated_name }}</a>
                    @endforeach
                </div>
            </section>

            <hr class="my-4">

            @foreach ($programs as $program)
                @php
                    $badgeClass = $program->is_flagship ? 'bg-danger' : ($program->slug === 'mandarin' ? 'bg-primary' : 'bg-success');
                    $featuresByGroup = collect($program->features)->groupBy->group;
                    // Fallback objects bukan instance model — hitung WA link manual
                    $waHref = $program instanceof \App\Models\Program
                        ? $program->waLink()
                        : 'https://wa.me/' . config('services.whatsapp.number') . '?text=' . rawurlencode($program->wa_prefill);
                @endphp
                <section id="{{ $program->slug }}" class="py-4 course-section">
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                        <h2 class="fw-bold mb-0">{{ $program->emoji }} {{ $program->translated_name }}</h2>
                        <span class="badge {{ $badgeClass }}">{{ $program->translated_badge }}</span>
                    </div>
                    <p class="text-muted">{{ $program->translated_intro }}</p>

                    @foreach (['level' => 'tabs', 'tier' => 'stepper', 'format' => 'cards', 'service_type' => 'cards', 'highlight' => 'card'] as $group => $renderer)
                        @php $groupFeatures = $featuresByGroup->get($group); @endphp

                        @php
                            // Heading grup: model group_meta = {title:{id,en,zh}, icon}; fallback = {title:string, icon}
                            $meta = $program->group_meta[$group] ?? null;
                            $metaTitle = is_array($meta['title'] ?? null)
                                ? ($meta['title'][app()->getLocale()] ?? $meta['title']['id'] ?? null)
                                : ($meta['title'] ?? null);
                            $groupHeading = $metaTitle ?: ucfirst(str_replace('_', ' ', $group));
                            $groupHeadingIcon = $meta['icon'] ?? 'fa-list';
                        @endphp
                        @if ($groupFeatures && $renderer === 'tabs')
                            {{-- Tab pills (levels) --}}
                            <h5 class="fw-bold mt-4"><i class="fa-solid {{ $groupHeadingIcon }} text-primary me-2"></i>{{ $groupHeading }}</h5>
                            <ul class="nav nav-pills mb-3" id="tabs-{{ $program->slug }}" role="tablist">
                                @foreach ($groupFeatures as $feature)
                                    <li class="nav-item"><button class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#tab-{{ $program->slug }}-{{ $loop->index }}" type="button">{{ $feature->translated_title }}</button></li>
                                @endforeach
                            </ul>
                            <div class="tab-content bg-light rounded p-4">
                                @foreach ($groupFeatures as $feature)
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ $program->slug }}-{{ $loop->index }}"><p class="mb-0">{{ $feature->translated_description }}</p></div>
                                @endforeach
                            </div>
                        @elseif ($groupFeatures && $renderer === 'stepper')
                            {{-- Stepper (jenjang Mandarin) --}}
                            <h5 class="fw-bold mt-4"><i class="fa-solid {{ $groupHeadingIcon }} text-primary me-2"></i>{{ $groupHeading }}</h5>
                            <div class="position-relative ps-4 mandarin-path">
                                @foreach ($groupFeatures as $feature)
                                    <div class="pb-4 position-relative mandarin-step">
                                        <span class="step-dot"><i class="fa-solid {{ $feature->icon }}"></i></span>
                                        <h6 class="fw-bold mb-1">{{ $feature->translated_title }}</h6>
                                        <p class="mb-0 small text-muted">{{ $feature->translated_description }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @elseif ($groupFeatures && $renderer === 'cards')
                            {{-- Kartu (format / service type) --}}
                            <h5 class="fw-bold mt-4"><i class="fa-solid {{ $groupHeadingIcon }} text-primary me-2"></i>{{ $groupHeading }}</h5>
                            <div class="row g-3">
                                @foreach ($groupFeatures as $feature)
                                    <div class="col-md-{{ $group === 'service_type' ? '4' : '6' }}">
                                        <div class="card h-100 border-0 shadow-sm"><div class="card-body">
                                            <h6 class="fw-bold mb-1"><i class="fa-solid {{ $feature->icon }} {{ $group === 'service_type' ? 'text-warning' : ($loop->first && $group === 'format' ? 'text-success' : 'text-primary') }} me-2"></i>{{ $feature->translated_title }}
                                                @if($feature->badge)<span class="badge bg-secondary ms-1">{{ $feature->badge }}</span>@endif
                                            </h6>
                                            <p class="mb-0 small text-muted">{{ $feature->translated_description }}</p>
                                        </div></div>
                                    </div>
                                @endforeach
                            </div>
                        @elseif ($groupFeatures && $renderer === 'card')
                            {{-- Kartu tunggal (highlight placement test) --}}
                            @foreach ($groupFeatures as $feature)
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body p-4">
                                        <h5 class="fw-bold"><i class="fa-solid {{ $feature->icon ?? $groupHeadingIcon }} text-success me-2"></i>{{ $feature->translated_title }}</h5>
                                        <p class="mb-0 text-muted">{{ $feature->translated_description }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endforeach

                    @if ($program->show_coming_soon)
                        <div class="alert alert-info d-inline-flex align-items-center gap-2 mt-2 mb-0">
                            <i class="fa-solid fa-bell"></i>
                            <span><strong>{{ __('messages.coming_soon_offline') }}</strong></span>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-dark p-2"><i class="fa-solid fa-building me-1"></i>{{ __('messages.svc_type_corporate') }}</span>
                        </div>
                    @endif

                    {{-- CTA program — WeChat + WhatsApp (solid) --}}
                    <div class="mt-4 p-3 rounded-3 d-flex flex-wrap gap-3 align-items-center justify-content-between shadow-sm" style="background:{{ $program->color }};">
                        <div class="text-white">
                            <div class="fw-bold"><i class="fa-solid fa-fire me-1"></i> {{ $program->translated_name }} — {{ $program->translated_badge }}</div>
                            <div class="small" style="opacity:.85;">{{ $program->translated_cta_text }}</div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light fw-bold px-4 text-dark" data-bs-toggle="modal" data-bs-target="#wechatModal"><i class="fa-brands fa-weixin me-1" style="color:#07C160;"></i> WeChat</button>
                            <a href="{{ $waHref }}" target="_blank" rel="noopener" class="btn fw-bold px-4 text-white" style="background:#25D366; border-color:#25D366;"><i class="fa-brands fa-whatsapp me-1"></i> WhatsApp</a>
                        </div>
                    </div>

                    {{-- Program lainnya --}}
                    <div class="mt-4 d-flex gap-2 align-items-center flex-wrap">
                        <span class="small text-muted fw-bold">{{ __('messages.other_programs') }}:</span>
                        @foreach ($programs->reject(fn ($p) => $p->slug === $program->slug) as $other)
                            <a href="#{{ $other->slug }}" class="badge bg-light text-dark text-decoration-none p-2">{{ $other->emoji }} {{ $other->translated_name }}</a>
                        @endforeach
                    </div>
                </section>

                @if (! $loop->last)
                    <hr class="my-4">
                @endif
            @endforeach

            <hr class="my-4">

            {{-- INFORMASI HARGA --}}
            <section class="py-4">
                <div class="text-center mb-4">
                    <span class="badge bg-warning bg-opacity-20 text-warning px-3 py-2 mb-2"><i class="fa-solid fa-tag me-1"></i> {{ __('messages.pricing_badge') }}</span>
                    <h3 class="fw-bold mb-2">{{ __('messages.pricing_title') }}</h3>
                    <p class="text-muted mx-auto" style="max-width:560px;">{{ __('messages.pricing_subtitle') }}</p>
                </div>
                <div class="row g-3 justify-content-center">
                    @foreach ($pricingPlans as $plan)
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4">
                                <i class="fa-solid {{ $plan->icon }} fa-2x {{ $plan->color ?? 'text-primary' }} mb-3"></i>
                                <h6 class="fw-bold">{{ $plan->translated_name }}</h6>
                                <p class="text-muted small mb-0">{{ $plan->translated_price_note }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-3">
                    <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text=Halo%20IF%20Language%20School%20-%20Info%20Harga" target="_blank" class="btn btn-primary fw-bold px-4"><i class="fa-brands fa-whatsapp me-1"></i> {{ __('messages.pricing_cta') }}</a>
                </div>
            </section>

            <hr class="my-4">

            {{-- CTA akhir --}}
            <section class="py-4 text-white rounded-3 px-4 text-center" style="background: linear-gradient(135deg, #1a2a4f 0%, #2d4a7a 100%);">
                <h4 class="fw-bold mb-2">{{ __('messages.cta_final_title') }}</h4>
                <p class="mb-3">{{ __('messages.cta_final_desc') }}</p>
                <a href="{{ route('contact', app()->getLocale()) }}" class="btn btn-warning fw-bold px-4">{{ __('messages.register_now') }}</a>
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
          <img src="{{ asset('images/wechat-qr.png') }}" alt="WeChat QR" class="img-fluid rounded-2" style="width:240px; height:240px; object-fit:contain;">
        </div>
        <h6 class="fw-bold mb-1">Scan untuk Hubungi Kami</h6>
        <p class="small text-muted mb-2">Buka WeChat → Scan QR di atas</p>
        <div class="bg-light rounded-3 p-2 small">
          <div class="fw-bold" style="color:#07C160;"><i class="fa-solid fa-qrcode me-1"></i> ID: IFLanguageSchool</div>
          <div class="text-muted" style="font-size:.75rem;">Atau cari ID di WeChat • Balas cepat di jam kerja</div>
        </div>
        <div class="d-grid gap-2 mt-3">
          <a href="{{ \App\Models\Program::first()?->waLink() ?? 'https://wa.me/' . config('services.whatsapp.number') }}" target="_blank" class="btn fw-bold text-white" style="background:#25D366; border-color:#25D366;"><i class="fa-brands fa-whatsapp me-1"></i> Atau chat WhatsApp</a>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
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
