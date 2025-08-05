@extends('layouts.app')
@section('title', __('Organizations'))
@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">{{ __('Organizations') }}</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($organizations as $org)
        <div class="bg-white shadow rounded p-6 flex flex-col">
            <div class="text-xl font-bold mb-1">{{ $org->name }}</div>
            <div class="mb-2 text-gray-700">{{ $org->description }}</div>
            <div class="mb-2 text-sm text-gray-500">{{ $org->city }}, {{ $org->country }}</div>
            <a href="{{ route('organizations.show', $org) }}" class="btn-primary mt-auto text-center">{{ __('View') }}</a>
        </div>
        @endforeach
    </div>
</div>
@endsection
