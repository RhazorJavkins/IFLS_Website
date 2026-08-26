@extends('layouts.app')

@section('title', __('messages.blog'))

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">{{ __('messages.blog') }}</h1>
    <p class="lead text-center">{{ __('messages.blog_intro') }}</p>
</div>
@endsection
