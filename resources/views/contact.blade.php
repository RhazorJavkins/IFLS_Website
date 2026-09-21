@extends('layouts.app')

@section('title', __('messages.contact'))

@section('content')
<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold mb-3">{{ __('messages.contact') }}</h1>
        <p class="lead text-muted mb-0">{{ __('messages.contact_intro') }}</p>
    </div>

    {{-- ===================== 1. QR CODES (5) ===================== --}}
    <div class="mb-5">
        <h5 class="fw-bold mb-3"><i class="fas fa-qrcode text-primary me-2"></i>{{ __('messages.contact_qr_title') }} <span class="text-muted fw-normal small">— {{ __('messages.contact_qr_scan') }}</span></h5>
        <div class="row g-3 g-md-4 justify-content-center">
            @for($i = 1; $i <= 5; $i++)
            <div class="col-6 col-md-4 col-lg">
                <div class="bg-white border border-2 rounded-3 p-2 h-100 shadow-sm" style="border-color: #e2e8f0 !important;">
                    <img src="{{ asset('images/qr-'.$i.'.png') }}" class="img-fluid rounded-2 mb-2 w-100" alt="QR {{ $i }}" width="300" height="300" loading="lazy" decoding="async" fetchpriority="low" style="max-height: 200px; object-fit: contain; background:#f8f9fa;">
                    <div class="small fw-bold text-dark text-center">QR Admin {{ $i }}</div>
                </div>
            </div>
            @endfor
        </div>
        <p class="text-muted small mt-2 mb-0"><i class="fas fa-circle-info me-1"></i> {!! __('messages.contact_qr_hint') !!}</p>
    </div>

    {{-- ===================== 2. LOKASI / ADDRESSES ===================== --}}
    <div class="mb-5">
        <h5 class="fw-bold mb-3"><i class="fas fa-location-dot text-danger me-2"></i>{{ __('messages.contact_location_title') }}</h5>
        <div class="row g-4">
            {{-- Head Office + Jakarta Learning Sites --}}
            <div class="col-lg-6">
                <div class="card shadow-sm h-100 border-0 border-top border-4" style="border-top-color: #0d6efd !important;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-1">{{ __('messages.contact_head_office') }} <span class="text-muted fw-normal">{{ __('messages.contact_head_office_sub') }}</span></h6>
                        <p class="mb-3 text-dark">
                            Rukan Cordoba Blok G No. 21-22<br>
                            Bukit Golf Mediterania, PIK, Jakarta Utara
                        </p>
                        <div class="bg-light rounded-3 p-3">
                            <div class="fw-bold small mb-2"><i class="fas fa-graduation-cap text-primary me-1"></i> {{ __('messages.contact_jakarta_sites') }}</div>
                            <ol class="mb-0 ps-3 small text-dark">
                                <li>PIK 1 <span class="text-muted">（雅加达北区）</span></li>
                                <li>Golf Island <span class="text-muted">（雅加达北区）</span></li>
                                <li>Central Park 2 <span class="text-muted">（雅加达西区）</span></li>
                                <li>Bellagio <span class="text-muted">（雅加达南区）</span></li>
                                <li>Serpong <span class="text-muted">（唐格朗）</span></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Surabaya + Semarang --}}
            <div class="col-lg-6">
                <div class="row g-4 h-100">
                    <div class="col-12">
                        <div class="card shadow-sm h-100 border-0 border-top border-4" style="border-top-color: #198754 !important;">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-1">{{ __('messages.contact_surabaya_branch') }} <span class="text-muted fw-normal">{{ __('messages.contact_surabaya_sub') }}</span></h6>
                                <p class="mb-0 text-dark">
                                    Plaza Ruko Graha Family<br>
                                    Jl. Mayjend. Jonosewojo No. Soewono<br>
                                    Blok C 42 Pradahkalikendal, Surabaya
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card shadow-sm h-100 border-0 border-top border-4" style="border-top-color: #fd7e14 !important;">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-1">{{ __('messages.contact_semarang_branch') }} <span class="text-muted fw-normal">{{ __('messages.contact_semarang_sub') }}</span></h6>
                                <p class="mb-0 text-dark">
                                    Jalan Batan Selatan, Miroto<br>
                                    Semarang Tengah, Semarang Kota
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== 3. MAP ===================== --}}
    <div class="mb-5">
        <div class="card shadow-sm overflow-hidden border-0">
            <div class="ratio ratio-21x9 bg-light position-relative" style="min-height: 280px;">
                <iframe
                    src="https://www.google.com/maps?q=VPQW%2B63+Kamal+Muara+Jakarta&z=16&output=embed"
                    style="border:0;"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="IF Language School HQ Map">
                </iframe>
            </div>
            <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
                <span class="small text-muted"><i class="fas fa-map-location-dot me-1 text-primary"></i> Rukan Cordoba Blok G No. 21-22, PIK — VPQW+63 Kamal Muara, Jakarta Utara</span>
                <a href="https://maps.app.goo.gl/PqB2Au16fx1MPTK6A" target="_blank" rel="noopener" class="btn btn-primary btn-sm">
                    <i class="fas fa-up-right-from-square me-1"></i> {{ __('messages.contact_map_open') }}
                </a>
            </div>
        </div>
    </div>

    {{-- ===================== 4. KONTAK + FORM (desain existing) ===================== --}}
    <div class="row g-4">
        {{-- Info kontak --}}
        <div class="col-lg-5">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h3 class="h5 fw-bold mb-4"><i class="fas fa-circle-info text-primary me-2"></i>{{ __('messages.contact_info') }}</h3>

                    <p class="mb-3">
                        <i class="fas fa-clock text-primary me-2"></i>
                        <strong>{{ __('messages.hours_label') }}:</strong><br>
                        <span class="text-muted ms-4 d-inline-block">{{ __('messages.hours_value') }}</span>
                    </p>

                    <p class="mb-3">
                        <i class="fab fa-whatsapp text-primary me-2"></i>
                        <strong>{{ __('messages.whatsapp') }}:</strong><br>
                        <span class="text-muted ms-4 d-inline-block">+62 811-8887-568</span>
                    </p>

                    <hr>
                    <p class="mb-1"><strong>{{ __('messages.follow_us') }}:</strong></p>
                    <div class="fs-4">
                        <a href="https://instagram.com/iflanguage" target="_blank" class="text-decoration-none me-3"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.facebook.com/iflanguage" target="_blank" class="text-decoration-none me-3"><i class="fab fa-facebook"></i></a>
                        <a href="https://tiktok.com/@iflanguage" target="_blank" class="text-decoration-none me-3"><i class="fab fa-tiktok"></i></a>
                        <a href="https://www.xiaohongshu.com/user/profile/iflanguage" target="_blank" class="text-decoration-none me-3"><i class="fa-solid fa-book-open" style="color:#FE2C55;"></i></a>
                        <a href="https://www.youtube.com/@iflanguage" target="_blank" class="text-decoration-none"><i class="fab fa-youtube"></i></a>
                    </div>
                    <div class="mt-3">
                        <a href="https://iflanguage.com" target="_blank" rel="noopener" class="small text-decoration-none"><i class="fas fa-globe me-1"></i> iflanguage.com</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div class="col-lg-7">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success"><i class="fas fa-circle-check me-1"></i>{{ __('messages.form_success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-warning"><i class="fas fa-triangle-exclamation me-1"></i>{{ __('messages.form_error') }}</div>
                    @endif
                    @error('message')
                        <div class="alert alert-warning"><i class="fas fa-triangle-exclamation me-1"></i>{{ $message }}</div>
                    @enderror

                    <form method="POST" action="{{ url(app()->getLocale() . '/contact') }}">
                        @csrf
                        {{-- Honeypot anti-bot: tersembunyi dari manusia; bot yang mengisi akan ditolak diam-diam --}}
                        <div class="d-none" aria-hidden="true">
                            <label for="website">Website</label>
                            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('messages.name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('messages.email') }} <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('messages.phone') }}</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="+62…">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('messages.contact_program') }}</label>
                                <select name="program" class="form-select">
                                    <option value="">{{ __('messages.contact_program_ph') }}</option>
                                    @foreach(['prog_mandarin', 'prog_indo', 'prog_english', 'svc_corporate', 'svc_doc_title', 'svc_sworn_title', 'svc_video_title', 'svc_interp_title', 'other_programs'] as $key)
                                        <option value="{{ __('messages.' . $key) }}" @selected(old('program') === __('messages.' . $key))>{{ __('messages.' . $key) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('messages.subject') }}</label>
                                <input type="text" name="subject" value="{{ old('subject') }}" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('messages.message') }} <span class="text-danger">*</span></label>
                                <textarea name="message" rows="5" class="form-control" required>{{ old('message') }}</textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-paper-plane me-1"></i>{{ __('messages.send_message') }}
                                </button>
                                <span class="ms-3 small text-muted">{{ __('messages.contact_wa_note') }}
                                    <a href="https://wa.me/628118887568" target="_blank" class="text-decoration-none fw-bold">WhatsApp</a> /
                                    <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none fw-bold align-baseline" data-bs-toggle="modal" data-bs-target="#wechatGlobalModal">WeChat</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
