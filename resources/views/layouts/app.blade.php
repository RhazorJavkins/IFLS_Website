<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IF Language School')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                <a href="#" class="text-white-50 text-decoration-none"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="text-white-50 text-decoration-none"><i class="fa-brands fa-weixin" style="color:#07C160;"></i></a>
            </div>
        </div>
    </div>

    <!-- ======= NAVBAR PREMIUM ======= -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top navbar-premium shadow-sm" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/' . app()->getLocale()) }}">
                <img src="{{ asset('logo.png') }}" alt="IF Language School" height="42" style="display:inline-block; filter: drop-shadow(0 1px 2px rgba(0,0,0,.3));">
                <span class="fw-bold ms-2" style="letter-spacing:.3px;">IF Language School</span>
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
                        <img src="{{ asset('logo.png') }}" alt="IF" height="36">
                        <span class="fw-bold ms-2">IF Language School</span>
                    </div>
                    <p class="small text-white-50 mb-2">{{ __('messages.welcome_subtitle') }}</p>
                    <p class="small text-white-50 mb-0"><i class="fa-solid fa-location-dot text-warning me-1"></i> Jakarta • Semarang • Surabaya</p>
                    <p class="small text-white-50"><i class="fa-solid fa-phone text-warning me-1"></i> +62 811-8887-568 • info@iflanguage.com</p>
                </div>
                <div class="col-6 col-md-4">
                    <h6 class="fw-bold mb-3">Menu</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-1"><a href="{{ url('/' . app()->getLocale() . '/courses') }}" class="text-white-50 text-decoration-none">{{ __('messages.courses') }}</a></li>
                        <li class="mb-1"><a href="{{ url('/' . app()->getLocale() . '/services') }}" class="text-white-50 text-decoration-none">{{ __('messages.services') }}</a></li>
                        <li class="mb-1"><a href="{{ url('/' . app()->getLocale() . '/about') }}" class="text-white-50 text-decoration-none">{{ __('messages.about') }}</a></li>
                        <li class="mb-1"><a href="{{ url('/' . app()->getLocale() . '/gallery') }}" class="text-white-50 text-decoration-none">{{ __('messages.gallery') }}</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-4">
                    <h6 class="fw-bold mb-3">{{ __('messages.contact') }}</h6>
                    <div class="d-flex gap-2 mb-3">
                        <a href="https://wa.me/628118887568" target="_blank" class="btn btn-success btn-sm rounded-circle" style="width:36px;height:36px; display:flex;align-items:center;justify-content:center;"><i class="fa-brands fa-whatsapp"></i></a>
                        <button class="btn btn-light btn-sm rounded-circle" style="width:36px;height:36px; display:flex;align-items:center;justify-content:center;" data-bs-toggle="modal" data-bs-target="#wechatGlobalModal"><i class="fa-brands fa-weixin" style="color:#07C160;"></i></button>
                        <a href="#" class="btn btn-dark btn-sm rounded-circle border border-secondary" style="width:36px;height:36px; display:flex;align-items:center;justify-content:center;"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                    <p class="small text-white-50 mb-0">Senin–Sabtu 09.00–21.00 WIB</p>
                </div>
            </div>
            <hr class="border-secondary border-opacity-25 my-4">
            <p class="small text-white-50 text-center mb-0">&copy; {{ date('Y') }} IF Language School • {{ __('messages.hero_badge') }} • {{ __('messages.language') }}: ID | EN | 中文</p>
        </div>
    </footer>

    <!-- Global WeChat Modal -->
    <div class="modal fade" id="wechatGlobalModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width:360px;">
        <div class="modal-content border-0 shadow">
          <div class="modal-header" style="background:#07C160;">
            <h6 class="modal-title text-white fw-bold"><i class="fa-brands fa-weixin me-1"></i> WeChat</h6>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center p-4">
            <img src="https://placehold.co/240x240/07C160/FFFFFF?text=WeChat+QR" alt="WeChat QR" class="img-fluid rounded-2 border p-2 mb-3" style="width:220px;">
            <div class="fw-bold small" style="color:#07C160;">ID: IFLanguageSchool</div>
            <div class="small text-muted">Scan di WeChat untuk konsultasi</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>.uni-slider::-webkit-scrollbar{display:none;} .uni-slider{scroll-behavior:smooth;}</style>
    <script>
        // Navbar shadow on scroll
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            if (window.scrollY > 10) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });
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
    </script>
</body>
</html>
