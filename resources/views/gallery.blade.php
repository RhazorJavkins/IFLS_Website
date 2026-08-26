@extends('layouts.app')

@section('title', __('messages.gallery'))

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">{{ __('messages.gallery') }}</h1>
    <p class="lead text-center">{{ __('messages.gallery_intro') }}</p>
</div>
@endsection
