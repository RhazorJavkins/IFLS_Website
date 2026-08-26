@extends('layouts.app')

@section('title', __('messages.services'))

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">{{ __('messages.services') }}</h1>
    <p class="lead text-center">{{ __('messages.services_intro') }}</p>
</div>
@endsection
