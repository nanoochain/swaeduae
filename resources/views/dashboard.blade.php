@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white rounded shadow p-8">
    <h1 class="text-2xl font-bold mb-4">{{ __('messages.dashboard_title') ?? 'Dashboard' }}</h1>
    <p>{{ __('messages.dashboard_welcome') ?? 'Welcome to your dashboard!' }}</p>
</div>
@endsection
