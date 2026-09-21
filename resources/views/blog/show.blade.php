@extends('layouts.app')

@section('title', $post->translated_title)

@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($post->translated_excerpt), 155))

@section('content')
<div class="container py-5" style="max-width:820px;">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home', app()->getLocale()) }}">{{ __('messages.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('blog', app()->getLocale()) }}">{{ __('messages.blog') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ \Illuminate\Support\Str::limit($post->translated_title, 40) }}</li>
        </ol>
    </nav>

    <article>
        <h1 class="fw-bold mb-3">{{ $post->translated_title }}</h1>
        <p class="text-muted mb-4">
            <i class="far fa-calendar me-1"></i>{{ $post->published_at?->translatedFormat('d F Y') }}
        </p>

        @if($post->cover_image)
            <img src="{{ asset('storage/' . $post->cover_image) }}" class="img-fluid rounded-4 mb-4" alt="{{ $post->translated_title }}">
        @endif

        <p class="lead text-muted">{{ $post->translated_excerpt }}</p>

        @foreach($post->paragraphs() as $paragraph)
            <p class="text-body">{{ $paragraph }}</p>
        @endforeach
    </article>

    <div class="card border-0 shadow-sm rounded-4 mt-5">
        <div class="card-body p-4 text-center">
            <h5 class="fw-bold mb-2">{{ __('messages.cta_final_title') }}</h5>
            <a href="https://wa.me/{{ config('services.whatsapp.number') }}" target="_blank" class="btn btn-success">
                <i class="fa-brands fa-whatsapp me-1"></i> WhatsApp
            </a>
            <a href="{{ route('contact', app()->getLocale()) }}" class="btn btn-primary ms-2">{{ __('messages.contact') }}</a>
        </div>
    </div>

</div>
@endsection
