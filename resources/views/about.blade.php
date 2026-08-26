@extends('layouts.app')

@section('title', 'About - IF Language School')

@section('content')
<div class="container py-5">
    <h1>{{ __('messages.about') }}</h1>
    <p>{{ __('messages.about_intro') }}</p>
</div>
@endsection