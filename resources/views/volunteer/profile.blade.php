@extends('layouts.app')
@section('title', __('My Volunteer Profile'))

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 mt-10 rounded shadow">
    <div class="flex gap-6 items-center mb-6">
        <img src="{{ Auth::user()->profile_photo_url ?? asset('images/default-avatar.png') }}" alt="Avatar" class="w-20 h-20 rounded-full border">
        <div>
            <h1 class="text-2xl font-bold">{{ Auth::user()->name }}</h1>
            <div class="text-gray-600">{{ Auth::user()->email }}</div>
            <div class="flex gap-2 mt-2">
                <!-- Example badges -->
                @if($hours >= 100)
                <span class="inline-block bg-yellow-400 text-white px-3 py-1 rounded text-xs font-bold" title="100+ hours">{{ __('Gold Volunteer') }}</span>
                @endif
                @if($events_count >= 10)
                <span class="inline-block bg-blue-400 text-white px-3 py-1 rounded text-xs font-bold" title="10+ events">{{ __('Active Participant') }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="mb-4">
        <strong>{{ __('Total Volunteer Hours:') }}</strong> {{ $hours }}<br>
        <strong>{{ __('Events Participated:') }}</strong> {{ $events_count }}
    </div>
    <div class="mb-4">
        <a href="{{ route('volunteer.resume') }}" class="bg-green-600 text-white px-4 py-2 rounded font-bold hover:bg-green-700" target="_blank">
            <i class="fa fa-download"></i> {{ __('Download Resume (PDF)') }}
        </a>
    </div>
    <div>
        <h2 class="font-bold mb-2">{{ __('Recent Events') }}</h2>
        <ul class="list-disc pl-6 text-gray-800">
            @foreach($recent_events as $ev)
                <li>{{ $ev->title }} <span class="text-gray-500 text-xs">({{ \Carbon\Carbon::parse($ev->date)->format('d M Y') }})</span></li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
