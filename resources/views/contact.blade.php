@extends('layouts.app')

@section('title', __('messages.contact'))

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">{{ __('messages.contact') }}</h1>
    <p class="lead text-center">{{ __('messages.contact_intro') }}</p>
</div>
@endsection
