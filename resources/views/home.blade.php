@extends('layouts.app')

@section('title', 'Home - IF Language School')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4 fw-bold">{{ __('messages.welcome_title') }}</h1>
            <p class="lead">{{ __('messages.welcome_subtitle') }}</p>
            <a href="{{ url('/' . app()->getLocale() . '/courses') }}" class="btn btn-primary btn-lg mt-3">
                {{ __('messages.get_started') }}
            </a>
        </div>
    </div>
</div>
@endsection