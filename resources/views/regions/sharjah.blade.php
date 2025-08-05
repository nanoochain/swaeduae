@extends('layouts.app')
@section('title', __('Volunteer in Sharjah'))

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-6">{{ __('Volunteer Opportunities in Sharjah') }}</h1>
    <p class="mb-6 text-gray-600">{{ __('Explore upcoming volunteer events and community initiatives in Sharjah.') }}</p>
    <ul class="divide-y divide-gray-200">
        @forelse($events as $event)
            <li class="py-3">
                <strong>{{ $event->title }}</strong> - {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                <a href="{{ route('events.show', $event->id) }}" class="ml-4 text-blue-700 font-bold hover:underline">{{ __('Details') }}</a>
            </li>
        @empty
            <li class="py-6 text-gray-500">{{ __('No events in Sharjah at this time.') }}</li>
        @endforelse
    </ul>
</div>
@endsection
