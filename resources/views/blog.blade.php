@extends('layouts.app')

@section('title', __('messages.blog'))

@section('content')
<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold mb-3">{{ __('messages.blog') }}</h1>
        <p class="lead text-muted mb-0">{{ __('messages.blog_intro') }}</p>
    </div>

    <div class="row g-4">
        @php
            $posts = [
                ['img' => 'https://placehold.co/600x400/5b8def/fff?text=Tips',  'title' => 'blog_post1_title', 'excerpt' => 'blog_post1_excerpt', 'date' => 'blog_post1_date'],
                ['img' => 'https://placehold.co/600x400/e0a458/fff?text=IELTS', 'title' => 'blog_post2_title', 'excerpt' => 'blog_post2_excerpt', 'date' => 'blog_post2_date'],
                ['img' => 'https://placehold.co/600x400/7bd88f/fff?text=Story', 'title' => 'blog_post3_title', 'excerpt' => 'blog_post3_excerpt', 'date' => 'blog_post3_date'],
            ];
        @endphp

        @foreach($posts as $post)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $post['img'] }}" class="card-img-top" alt="{{ __("messages.{$post['title']}") }}">
                    <div class="card-body d-flex flex-column">
                        <small class="text-muted mb-2"><i class="far fa-calendar me-1"></i>{{ __("messages.{$post['date']}") }}</small>
                        <h3 class="h5 fw-bold">{{ __("messages.{$post['title']}") }}</h3>
                        <p class="text-muted small flex-grow-1">{{ __("messages.{$post['excerpt']}") }}</p>
                        <a href="#" class="btn btn-primary btn-sm align-self-start">{{ __('messages.read_more') }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
