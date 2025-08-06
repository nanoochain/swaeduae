@extends('layouts.app')

@section('title', __('Make a Difference Today'))

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-3xl font-bold text-blue-900 mb-4">{{ __('Make a Difference Today') }}</h1>
    <p>Join thousands of volunteers across the UAE contributing their time to meaningful causes.</p>
    <a href="{{ route('opportunities.index') }}" class="text-blue-700 hover:underline mt-2 inline-block">{{ __('Explore Volunteer Opportunities') }}</a>
    <img src="/images/hero-volunteer.png" alt="Volunteering" class="mt-4 rounded shadow max-w-xs">

    <h2 class="font-bold mt-8 mb-2">{{ __('Upcoming Volunteer Opportunities') }}</h2>
    <div>
        @if(isset($events) && count($events))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($events->take(3) as $event)
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-xl font-bold mb-2">{{ $event->title }}</h3>
                        <p class="text-gray-600 mb-2">{{ Illuminate\Support\Str::limit($event->description, 120) }}</p>
                        <p class="text-sm text-gray-500">{{ __('Location:') }} {{ $event->city ?? __('Online') }}</p>
                        <p class="text-sm text-gray-500">{{ __('Date:') }} {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</p>
                        <a href="{{ route('events.show', $event->id) }}" class="mt-2 inline-block text-blue-700 hover:underline">{{ __('View Event') }}</a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-500">{{ __('No volunteer opportunities found.') }}</div>
        @endif
    </div>

    <h2 class="font-bold mt-8 mb-2">{{ __('Latest News') }}</h2>
    <div>
        @if(isset($news) && count($news))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($news->take(3) as $post)
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-xl font-bold mb-2">{{ $post->title }}</h3>
                        <p class="text-gray-600 mb-2">{{ Illuminate\Support\Str::limit($post->body, 120) }}</p>
                        <a href="{{ route('news.show', $post->id) }}" class="mt-2 inline-block text-blue-700 hover:underline">{{ __('Read More') }}</a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-500">{{ __('No news found.') }}</div>
        @endif
    </div>
</div>
@endsection
