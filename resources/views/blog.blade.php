@extends('layouts.app')

@section('title', __('messages.blog'))

@section('content')
<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold mb-3">{{ __('messages.blog') }}</h1>
        <p class="lead text-muted mb-0">{{ __('messages.blog_intro') }}</p>
    </div>

    @php
        // DB-first: post dikelola via /admin; fallback ke lang file bila DB kosong
        $posts = $posts ?? collect([1, 2, 3])->map(fn ($i) => (object) [
            'slug' => null,
            'translated_title' => __("messages.blog_post{$i}_title"),
            'translated_excerpt' => __("messages.blog_post{$i}_excerpt"),
            'date' => __("messages.blog_post{$i}_date"),
            'gradient' => ['linear-gradient(135deg,#5b8def,#3f6fd8)','linear-gradient(135deg,#e0a458,#d88a3f)','linear-gradient(135deg,#7bd88f,#4fae66)'][$i - 1],
        ]);
    @endphp

    <div class="row g-4">
        @foreach($posts as $post)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    @if(!empty($post->cover_image))
                        <img src="{{ asset('storage/' . $post->cover_image) }}" class="card-img-top" alt="{{ $post->translated_title }}">
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center text-white fw-bold" style="height:180px;background:{{ $post->gradient ?? 'linear-gradient(135deg,#5b8def,#3f6fd8)' }};font-size:1.4rem;">
                            IF Blog
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <small class="text-muted mb-2"><i class="far fa-calendar me-1"></i>{{ $post->date ?? '' }}</small>
                        <h3 class="h5 fw-bold">{{ $post->translated_title }}</h3>
                        <p class="text-muted small flex-grow-1">{{ $post->translated_excerpt }}</p>
                        @if(!empty($post->slug))
                            <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'slug' => $post->slug]) }}" class="btn btn-primary btn-sm align-self-start">{{ __('messages.read_more') }}</a>
                        @else
                            <a href="https://wa.me/{{ config('services.whatsapp.number') }}" target="_blank" class="btn btn-primary btn-sm align-self-start">{{ __('messages.read_more') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
