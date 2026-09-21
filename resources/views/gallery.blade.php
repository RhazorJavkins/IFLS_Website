@extends('layouts.app')

@section('title', __('messages.gallery'))

@section('content')
<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold mb-3">{{ __('messages.gallery') }}</h1>
        <p class="lead text-muted mb-0">{{ __('messages.gallery_intro') }}</p>
    </div>

    {{-- DRAFT: ganti src dengan foto asli di folder public/images/gallery/ --}}
    <div class="row g-3">
        @php
            $photos = [
                ['Kelas Online',  'Online Class',  'fa-laptop'],
                ['Seminar IELTS', 'IELTS Seminar', 'fa-microphone'],
                ['Kelas Grup',    'Group Class',   'fa-users'],
                ['Wisuda Siswa',  'Graduation',    'fa-graduation-cap'],
                ['Kegiatan Luar', 'Field Trip',    'fa-bus'],
                ['Workshop',      'Workshop',      'fa-chalkboard-user'],
            ];
        @endphp

        @foreach($photos as $photo)
            <div class="col-6 col-md-4">
                <div class="ratio ratio-4x3 border rounded-3 d-flex align-items-center justify-content-center bg-light position-relative overflow-hidden">
                    <div class="text-center text-muted p-3">
                        <i class="fas {{ $photo[2] }} fa-2x mb-2 d-block"></i>
                        <small>{{ __($photo[0]) }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ===== PARTNER KAMI ===== --}}
    <section class="mt-5 pt-5 border-top">
        <div class="text-center mb-4">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3">{{ __('messages.gallery_partners_badge') }}</span>
            <h2 class="fw-bold mb-2">{{ __('messages.gallery_partners_title') }} <span class="text-primary">— {{ __('messages.gallery_partners_count') }}</span></h2>
            <p class="text-muted mx-auto" style="max-width:640px;">{{ __('messages.gallery_partners_desc') }}</p>
        </div>

        <div class="row g-3 g-md-4 align-items-stretch">
            @php
                $partners = [
                    ['Huawei', 'Teknologi', '#ff0000'],
                    ['Bank of China', 'Perbankan', '#b03a3a'],
                    ['Sinarmas', 'Konglomerat', '#1a2a4f'],
                    ['Midea', 'Manufaktur', '#0d6efd'],
                    ['Alibaba', 'E-commerce', '#ff6a00'],
                    ['BYD', 'Otomotif', '#198754'],
                    ['ICBC', 'Keuangan', '#7a1f1f'],
                    ['Tencent', 'Teknologi', '#2d4a7a'],
                    ['Unilever', 'FMCG', '#0055a5'],
                    ['Astra', 'Otomotif', '#444'],
                    ['Telkom', 'Telekomunikasi', '#d00'],
                    ['Binus', 'Edukasi', '#003366'],
                ];
            @endphp

            @foreach($partners as $p)
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <div class="partner-card bg-white border rounded-3 d-flex flex-column align-items-center justify-content-center text-center p-3 h-100 shadow-sm">
                        {{-- Placeholder logo: ganti dengan <img src="{{ asset('images/partners/partnerX.png') }}" alt="{{ $p[0] }}" class="img-fluid" style="max-height:46px;"> --}}
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-2 fw-bold text-white" style="width:48px;height:48px;background:{{ $p[2] }}; font-size:.85rem;">
                            {{ strtoupper(substr($p[0],0,2)) }}
                        </div>
                        <div class="fw-bold small mb-0" style="line-height:1.2;">{{ $p[0] }}</div>
                        <div class="text-muted" style="font-size:.70rem;">{{ $p[1] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="alert alert-light border d-flex align-items-center gap-2 mt-4 small text-muted mb-0">
            <i class="fa-solid fa-circle-info text-primary"></i>
            <span>{!! __('messages.gallery_partners_note') !!}</span>
        </div>
    </section>

</div>

<style>
    .partner-card { transition: transform .18s ease, box-shadow .18s ease; }
    .partner-card:hover { transform: translateY(-4px); box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.10) !important; }
</style>
@endsection
