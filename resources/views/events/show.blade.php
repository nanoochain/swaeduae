@extends('layouts.app')

@section('title', $event->title . ' | Event')

@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-8 max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-blue-900 mb-2">{{ $event->title }}</h1>
        <div class="mb-3 text-gray-600">{{ $event->location }} | {{ $event->date }}</div>
        <p class="mb-4">{{ $event->description }}</p>
        <a href="{{ route('events.index') }}" class="text-green-700 hover:underline">← Back to Events</a>
    </div>
</div>
@endsection
