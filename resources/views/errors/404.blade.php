@extends('layouts.app')
@section('title', '404 — Halaman Tidak Ditemukan')
@section('content')
<div class="container py-5 text-center" style="min-height: 60vh; display:flex; flex-direction:column; align-items:center; justify-content:center;">
    <div style="font-size: 5rem; opacity:.15;">404</div>
    <h1 class="fw-bold mb-2">Halaman Tidak Ditemukan</h1>
    <p class="text-muted mb-4" style="max-width:480px;">URL yang kamu buka tidak tersedia atau sudah dipindahkan. Coba kembali ke beranda atau hubungi kami via WhatsApp / WeChat.</p>
    <div class="d-flex gap-2 justify-content-center flex-wrap">
        <a href="{{ url('/'.app()->getLocale()) }}" class="btn btn-warning fw-bold px-4"><i class="fa-solid fa-house me-1"></i> {{ __('messages.home') }}</a>
        <a href="{{ url('/'.app()->getLocale().'/contact') }}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-envelope me-1"></i> {{ __('messages.contact') }}</a>
        <a href="https://wa.me/628118887568" target="_blank" class="btn btn-success px-4"><i class="fa-brands fa-whatsapp me-1"></i> WhatsApp</a>
    </div>
</div>
@endsection
