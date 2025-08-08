@extends('layouts.app')
@section('title', __('messages.about'))
@section('content')
<div class="card p-4"><h3 class="mb-3">{{ __('messages.about') }}</h3><p class="text-muted">{{ __('messages.about_text') }}</p></div>
@endsection
