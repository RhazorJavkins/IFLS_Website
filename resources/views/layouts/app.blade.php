@php
    $locale = app()->getLocale();
    $path = request()->path();
    $pathNoLocale = preg_replace('#^(' . $locale . ')#', '', $path === '/' ? '' : $path);
    $alternates = [];
    foreach (['id' => 'id-ID', 'en' => 'en', 'zh' => 'zh-CN'] as $code => $hreflang) {
        $alternates[$hreflang] = url(trim($code . $pathNoLocale, '/'));
    }
    // Konten SEO per locale
    $seo = [
        'id' => [
            'desc' => 'IF Language School — kursus bahasa Mandarin, Inggris & Indonesia untuk WNA sejak 2012 di Jakarta, Semarang, Surabaya. Penerjemah tersumpah resmi & interpreter ID⇄CN⇄EN. Mitra Badan Bahasa Kemendikbudristek. Konsultasi gratis!',
            'homeTitle' => 'IF Language School — Kursus Mandarin, Inggris & Terjemahan Tersumpah di Jakarta',
        ],
        'en' => [
            'desc' => 'IF Language School — Mandarin, English & Indonesian courses for expatriates since 2012 in Jakarta, Semarang & Surabaya. Certified sworn translation & interpreting ID⇄CN⇄EN. Official partner of the government Language Agency. Free consultation!',
            'homeTitle' => 'IF Language School — Mandarin & English Courses, Sworn Translation in Jakarta',
        ],
        'zh' => [
            'desc' => '艾孚语言学校——自2012年起在雅加达、三宝垄、泗水提供中文、英文及对外印尼语课程，以及官方认证宣誓翻译与口译服务（印尼语⇄中文⇄英文）。印尼教育部语言司合作伙伴。免费咨询！',
            'homeTitle' => '艾孚语言学校 — 雅加达中文/英文课程与宣誓翻译服务',
        ],
    ][$locale];
    $isHome = request()->routeIs('home');
    $pageTitle = $isHome ? $seo['homeTitle'] : $__env->yieldContent('title') . ' | IF Language School';
    $metaDesc = $__env->yieldContent('meta_description') ?: $seo['desc'];
    $ogImage = url('images/og-cover.png');
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDesc }}">
    <link rel="canonical" href="{{ url($locale . $pathNoLocale) }}">
    @foreach ($alternates as $lang => $u)
        <link rel="alternate" hreflang="{{ $lang }}" href="{{ $u }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ url('id' . $pathNoLocale) }}">
    {{-- Open Graph / WhatsApp / Twitter --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="IF Language School">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDesc }}">
    <meta property="og:url" content="{{ url($locale . $pathNoLocale) }}">
    <meta property="og:image" content="{{ $ogImage }}">
    @php $ogLocaleTag = ['id' => 'id_ID', 'en' => 'en_US', 'zh' => 'zh_CN'][$locale]; @endphp
    <meta property="og:locale" content="{{ $ogLocaleTag }}">
    @foreach(['id_ID', 'en_US', 'zh_CN'] as $alt)
        @if($alt !== $ogLocaleTag)
            <meta property="og:locale:alternate" content="{{ $alt }}">
        @endif
    @endforeach
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $metaDesc }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
    @if($isHome)
    {{-- Structured data: LocalBusiness (SEO) --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": ["EducationalOrganization", "LocalBusiness"],
      "name": "IF Language School",
      "alternateName": "IF Language Center",
      "url": "{{ url($locale) }}",
      "logo": "{{ url('logo.png') }}",
      "image": "{{ $ogImage }}",
      "telephone": "+628118887568",
      "email": "info@iflanguage.com",
      "foundingDate": "2012",
      "priceRange": "$",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Rukan Cordoba Blok G No. 21-22, Bukit Golf Mediterania, PIK",
        "addressLocality": "Jakarta Utara",
        "addressRegion": "DKI Jakarta",
        "addressCountry": "ID"
      },
      "openingHours": "Mo-Fr 08:30-17:30",
      "sameAs": [
        "https://instagram.com/iflanguage",
        "https://tiktok.com/@iflanguage",
        "https://www.facebook.com/iflanguage",
        "https://www.youtube.com/@iflanguage"
      ]
    }
    </script>
    @endif
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .topbar { font-size: .78rem; letter-spacing:.2px; }
        .navbar-premium { backdrop-filter: blur(10px); transition: box-shadow .2s ease; }
        .navbar-premium.scrolled { box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important; }
        .nav-link.active { font-weight:700; position:relative; }
        .nav-link.active::after { content:""; position:absolute; left:8px; right:8px; bottom:4px; height:2px; background:#FFD166; border-radius:2px; }
        @media (max-width: 991px) { .nav-link.active::after { display:none; } }
    </style>
</head>
<body>

    <!-- ======= TOPBAR ======= -->
    <div class="topbar bg-dark text-white-50 py-2 d-none d-md-block border-bottom border-secondary border-opacity-25">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex gap-3">
                <span><i class="fa-solid fa-location-dot text-warning me-1"></i> Jakarta • Semarang • Surabaya</span>
                <span class="d-none d-lg-inline"><i class="fa-solid fa-phone text-warning me-1"></i> +62 811-8887-568</span>
                <span class="d-none d-xl-inline"><i class="fa-solid fa-envelope text-warning me-1"></i> info@iflanguage.com</span>
            </div>
            <div class="d-flex gap-3 align-items-center">
                <span class="d-none d-lg-inline"><i class="fa-solid fa-award text-warning me-1"></i> {{ __('messages.hero_badge') }}</span>
                <span class="vr bg-secondary opacity-25"></span>
                <a href="https://wa.me/628118887568" target="_blank" class="text-white-50 text-decoration-none"><i class="fa-brands fa-whatsapp"></i></a>
                <a href="https://instagram.com/iflanguage" target="_blank" class="text-white-50 text-decoration-none"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://tiktok.com/@iflanguage" target="_blank" class="text-white-50 text-decoration-none"><i class="fa-brands fa-tiktok"></i></a>
                <a href="#" class="text-white-50 text-decoration-none"><i class="fa-brands fa-weixin" style="color:#07C160;"></i></a>
            </div>
        </div>
    </div>

    <!-- ======= NAVBAR PREMIUM ======= -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top navbar-premium shadow-sm" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/' . app()->getLocale()) }}">
                <img src="{{ asset('logo.png') }}" alt="IF Language School" height="48" style="display:inline-block;">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @php $locale = app()->getLocale(); $path = trim(request()->path(), '/'); @endphp
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item"><a class="nav-link {{ $path === $locale || $path === $locale.'/' ? 'active' : '' }}" href="{{ url('/' . $locale . '/') }}">{{ __('messages.home') }}</a></li>
                    <li class="nav-item"><a class="nav-link {{ str_contains($path, '/about') ? 'active' : '' }}" href="{{ url('/' . $locale . '/about') }}">{{ __('messages.about') }}</a></li>
                    <li class="nav-item"><a class="nav-link {{ str_contains($path, '/courses') ? 'active' : '' }}" href="{{ url('/' . $locale . '/courses') }}">{{ __('messages.courses') }}</a></li>
                    <li class="nav-item"><a class="nav-link {{ str_contains($path, '/services') ? 'active' : '' }}" href="{{ url('/' . $locale . '/services') }}">{{ __('messages.services') }}</a></li>
                    <li class="nav-item"><a class="nav-link {{ str_contains($path, '/blog') ? 'active' : '' }}" href="{{ url('/' . $locale . '/blog') }}">{{ __('messages.blog') }}</a></li>
                    <li class="nav-item"><a class="nav-link {{ str_contains($path, '/gallery') ? 'active' : '' }}" href="{{ url('/' . $locale . '/gallery') }}">{{ __('messages.gallery') }}</a></li>
                    <li class="nav-item"><a class="nav-link {{ str_contains($path, '/contact') ? 'active' : '' }}" href="{{ url('/' . $locale . '/contact') }}">{{ __('messages.contact') }}</a></li>

                    <!-- DROPDOWN SWITCH BAHASA -->
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle border rounded-pill px-3" href="#" id="langDropdown" role="button" data-bs-toggle="dropdown" style="border-color: #495057 !important; font-size:.85rem;">
                            🌐 {{ strtoupper(app()->getLocale()) }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            @php
                                $segments = request()->segments();
                                $pathWithoutLocale = implode('/', array_slice($segments, 1));
                                $queryString = request()->query() ? '?' . http_build_query(request()->query()) : '';
                            @endphp
                            <li><a class="dropdown-item" href="{{ url('id/' . $pathWithoutLocale . $queryString) }}">🇮🇩 Indonesia</a></li>
                            <li><a class="dropdown-item" href="{{ url('en/' . $pathWithoutLocale . $queryString) }}">🇬🇧 English</a></li>
                            <li><a class="dropdown-item" href="{{ url('zh/' . $pathWithoutLocale . $queryString) }}">🇨🇳 中文</a></li>
                        </ul>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a href="https://wa.me/628118887568?text=Halo%20IF%20Language%20School" target="_blank" class="btn btn-warning btn-sm fw-bold px-3 rounded-pill">
                            <i class="fa-brands fa-whatsapp me-1"></i> {{ __('messages.register_now') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ======= BREADCRUMB ======= -->
    @php
        $locale = app()->getLocale();
        // hide breadcrumb di home
        $seg = request()->segments();
        $pathNoLocale = implode('/', array_slice($seg, 1));
        $showBreadcrumb = !empty($pathNoLocale);
        $crumbMap = [
            'about' => __('messages.about'),
            'courses' => __('messages.courses'),
            'services' => __('messages.services'),
            'gallery' => __('messages.gallery'),
            'contact' => __('messages.contact'),
            'blog' => __('messages.blog'),
        ];
    @endphp
    @if($showBreadcrumb)
    <nav aria-label="breadcrumb" class="bg-light border-bottom">
        <div class="container py-2">
            <ol class="breadcrumb mb-0 small" style="--bs-breadcrumb-divider: '›';">
                <li class="breadcrumb-item"><a href="{{ url('/'.$locale) }}" class="text-decoration-none"><i class="fa-solid fa-house me-1"></i>{{ __('messages.home') }}</a></li>
                @php $accum=''; @endphp
                @foreach(array_slice($seg,1) as $s)
                    @php $accum .= '/'.$s; @endphp
                    @if($loop->last)
                        <li class="breadcrumb-item active" aria-current="page">{{ $crumbMap[$s] ?? ucfirst(str_replace('-',' ',$s)) }}</li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ url('/'.$locale.$accum) }}" class="text-decoration-none">{{ $crumbMap[$s] ?? ucfirst(str_replace('-',' ',$s)) }}</a></li>
                    @endif
                @endforeach
            </ol>
        </div>
    </nav>
    @endif

    <!-- ======= CONTENT ======= -->
    <main>
        @yield('content')
    </main>

    <!-- ======= FOOTER ======= -->
    <footer class="bg-dark text-white pt-5 pb-4 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('logo-square.png') }}" alt="IF" height="56" style="display:inline-block;">
                    </div>
                    <p class="small text-white-50 mb-2">{{ __('messages.welcome_subtitle') }}</p>
                    <p class="small text-white-50 mb-0"><i class="fa-solid fa-location-dot text-warning me-1"></i> Jakarta • Semarang • Surabaya</p>
                    <p class="small text-white-50"><i class="fa-solid fa-phone text-warning me-1"></i> +62 811-8887-568 • info@iflanguage.com</p>
                </div>
                <div class="col-6 col-md-4">
                    <h6 class="fw-bold mb-3">Menu</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-1"><a href="{{ url('/' . app()->getLocale() . '/') }}" class="text-white-50 text-decoration-none">{{ __('messages.home') }}</a></li>
                        <li class="mb-1"><a href="{{ url('/' . app()->getLocale() . '/about') }}" class="text-white-50 text-decoration-none">{{ __('messages.about') }}</a></li>
                        <li class="mb-1"><a href="{{ url('/' . app()->getLocale() . '/courses') }}" class="text-white-50 text-decoration-none">{{ __('messages.courses') }}</a></li>
                        <li class="mb-1"><a href="{{ url('/' . app()->getLocale() . '/services') }}" class="text-white-50 text-decoration-none">{{ __('messages.services') }}</a></li>
                        <li class="mb-1"><a href="{{ url('/' . app()->getLocale() . '/gallery') }}" class="text-white-50 text-decoration-none">{{ __('messages.gallery') }}</a></li>
                        <li class="mb-1"><a href="{{ url('/' . app()->getLocale() . '/contact') }}" class="text-white-50 text-decoration-none">{{ __('messages.contact') }}</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-4">
                    <h6 class="fw-bold mb-3">{{ __('messages.contact') }}</h6>
                    <div class="d-flex gap-2 mb-3">
                        <a href="https://wa.me/628118887568" target="_blank" class="btn btn-success btn-sm rounded-circle" style="width:36px;height:36px; display:flex;align-items:center;justify-content:center;"><i class="fa-brands fa-whatsapp"></i></a>
                        <button class="btn btn-light btn-sm rounded-circle" style="width:36px;height:36px; display:flex;align-items:center;justify-content:center;" data-bs-toggle="modal" data-bs-target="#wechatGlobalModal"><i class="fa-brands fa-weixin" style="color:#07C160;"></i></button>
                        <a href="https://instagram.com/iflanguage" target="_blank" class="btn btn-dark btn-sm rounded-circle border border-secondary" style="width:36px;height:36px; display:flex;align-items:center;justify-content:center;"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.facebook.com/iflanguage" target="_blank" class="btn btn-dark btn-sm rounded-circle border border-secondary" style="width:36px;height:36px; display:flex;align-items:center;justify-content:center;"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://tiktok.com/@iflanguage" target="_blank" class="btn btn-dark btn-sm rounded-circle border border-secondary" style="width:36px;height:36px; display:flex;align-items:center;justify-content:center;"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="https://www.xiaohongshu.com/user/profile/iflanguage" target="_blank" class="btn btn-dark btn-sm rounded-circle border border-secondary" style="width:36px;height:36px; display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-book-open" style="color:#FE2C55;"></i></a>
                    </div>
                    <p class="small text-white-50 mb-0">Senin–Jumat 08.30–17.30 WIB</p>
                </div>
            </div>
            <hr class="border-secondary border-opacity-25 my-4">
            <p class="small text-white-50 text-center mb-0">&copy; {{ date('Y') }} IF Language School • {{ __('messages.hero_badge') }} • {{ __('messages.language') }}: ID | EN | 中文</p>
        </div>
    </footer>

    <!-- ======= BACK TO TOP ======= -->
    <button id="backToTop" type="button" class="btn btn-warning rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="position:fixed; right:18px; bottom:90px; width:44px; height:44px; z-index:1030; opacity:0; visibility:hidden; transition: opacity .2s, visibility .2s, transform .2s; transform: translateY(8px);" aria-label="Back to top">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <!-- ======= STICKY CTA MOBILE ======= -->
    <div class="d-flex d-md-none position-fixed bottom-0 start-0 end-0 bg-white border-top shadow-lg p-2 gap-2" style="z-index:1029; padding-bottom: max(8px, env(safe-area-inset-bottom));">
        <a href="https://wa.me/628118887568?text=Halo%20IF%20Language%20School" target="_blank" class="btn btn-success fw-bold flex-fill"><i class="fa-brands fa-whatsapp me-1"></i> WhatsApp</a>
        <button class="btn btn-dark flex-fill" data-bs-toggle="modal" data-bs-target="#wechatGlobalModal"><i class="fa-brands fa-weixin me-1" style="color:#07C160;"></i> WeChat</button>
        <a href="{{ url('/'.app()->getLocale().'/contact') }}" class="btn btn-warning fw-bold flex-fill"><i class="fa-solid fa-phone me-1"></i> {{ __('messages.contact') }}</a>
    </div>

    <!-- Global WeChat Modal -->
    <div class="modal fade" id="wechatGlobalModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width:360px;">
        <div class="modal-content border-0 shadow">
          <div class="modal-header" style="background:#07C160;">
            <h6 class="modal-title text-white fw-bold"><i class="fa-brands fa-weixin me-1"></i> WeChat</h6>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center p-4">
            <img src="{{ asset('images/wechat-qr.png') }}" alt="WeChat QR" class="img-fluid rounded-2 border p-2 mb-3" style="width:220px;">
            <div class="fw-bold small" style="color:#07C160;">ID: IFLanguageSchool</div>
            <div class="small text-muted">Scan di WeChat untuk konsultasi</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Google Analytics 4 — aktif hanya jika GA_MEASUREMENT_ID diisi di .env --}}
    @if(!empty(config('services.analytics.ga_id')))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.analytics.ga_id') }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ config('services.analytics.ga_id') }}');
    </script>
    @endif
    <style>.uni-slider::-webkit-scrollbar{display:none;} .uni-slider{scroll-behavior:smooth;}
    /* Skeleton loading untuk gambar — OPT-IN saja.
       JANGAN pakai rule global img { background: ... }: area transparan PNG
       (mis. logo putih) akan menampilkan warna background elemen, sehingga
       glyph putih hilang di navbar gelap. */
    img.loading-skeleton { background: linear-gradient(90deg, #e9ecef 25%, #f8f9fa 37%, #e9ecef 63%); background-size: 400% 100%; animation: skeletonShimmer 1.2s ease-in-out infinite; }
    @keyframes skeletonShimmer { 0% { background-position: 100% 0; } 100% { background-position: -100% 0; } }
    /* beri ruang bawah agar sticky CTA mobile tidak nutup konten */
    @media (max-width: 767px) { body { padding-bottom: 64px; } }
    </style>
    <script>
        // Navbar shadow on scroll
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            if (window.scrollY > 10) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });
        // Back to top
        (function(){
            const btn = document.getElementById('backToTop');
            if(!btn) return;
            window.addEventListener('scroll', function(){
                if(window.scrollY > 300){ btn.style.opacity='1'; btn.style.visibility='visible'; btn.style.transform='translateY(0)'; }
                else { btn.style.opacity='0'; btn.style.visibility='hidden'; btn.style.transform='translateY(8px)'; }
            }, {passive:true});
            btn.addEventListener('click', function(){ window.scrollTo({top:0, behavior:'smooth'}); });
        })();
        // Uni slider prev/next
        document.addEventListener('click', function(e){
            const btn = e.target.closest('.uni-prev, .uni-next');
            if(!btn) return;
            const id = btn.getAttribute('data-target');
            const el = document.getElementById(id);
            if(!el) return;
            const dir = btn.classList.contains('uni-prev') ? -1 : 1;
            el.scrollBy({left: dir*280, behavior:'smooth'});
        });
        // Tracking klik CTA (WA / WeChat) → GA4 jika aktif, selalu console.debug utk debug
        document.addEventListener('click', function(e){
            const wa = e.target.closest('a[href*="wa.me"]');
            const wx = e.target.closest('[data-bs-target="#wechatGlobalModal"], [data-bs-target="#wechatModal"]');
            if(!wa && !wx) return;
            const label = wa ? 'whatsapp_click' : 'wechat_open';
            const page = window.location.pathname;
            if (typeof gtag === 'function') {
                gtag('event', label, { 'page_path': page });
            }
            console.debug('[CTA]', label, page);
        });
    </script>
</body>
</html>
