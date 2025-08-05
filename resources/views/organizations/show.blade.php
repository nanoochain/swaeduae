@extends('layouts.app')
@section('title', $organization->name)
@section('content')
<div class="max-w-2xl mx-auto bg-white rounded shadow p-8">
    <h1 class="text-3xl font-bold mb-2">{{ $organization->name }}</h1>
    <div class="mb-2 text-gray-500">{{ $organization->city }}, {{ $organization->country }}</div>
    <div class="mb-4">{{ $organization->description }}</div>
    <h2 class="text-xl font-bold mb-2">{{ __('Events by this Organization') }}</h2>
    @include('partials.events-list', ['events' => $organization->events])
</div>
@endsection
