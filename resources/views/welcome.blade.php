@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-blue-900 text-white">
    <div class="max-w-7xl mx-auto px-6 py-24 flex flex-col md:flex-row items-center gap-10">
        <div class="md:w-1/2">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight">{{ __('Make a Difference Today') }}</h1>
            <p class="mb-8 text-lg">{{ __('Join thousands of volunteers across the UAE contributing their time to meaningful causes.') }}</p>
            <a href="{{ route('events.index') }}" class="inline-block bg-yellow-400 text-blue-900 font-semibold py-3 px-6 rounded-lg shadow hover:bg-yellow-500 transition">{{ __('Explore Volunteer Opportunities') }}</a>
        </div>
        <div class="md:w-1/2">
            <img src="{{ asset('images/hero-volunteer.png') }}" alt="{{ __('Volunteering') }}" class="rounded-lg shadow-lg">
        </div>
    </div>
</section>

<!-- Volunteer Opportunities Preview -->
<section class="max-w-7xl mx-auto px-6 py-16">
    <h2 class="text-3xl font-bold text-blue-900 mb-8">{{ __('Upcoming Volunteer Opportunities') }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($events->take(3) as $event)
        <div class="bg-white rounded-lg shadow p-6 flex flex-col">
            <h3 class="text-xl font-semibold mb-2">{{ $event->title }}</h3>
            <p class="text-gray-600 mb-4">{{ \Illuminate\Support\Str::limit($event->description, 120) }}</p>
            <p class="text-sm text-gray-500 mb-2">{{ __('Location:') }} {{ $event->city ?? __('Online') }}</p>
            <p class="text-sm text-gray-500 mb-4">{{ __('Date:') }} {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
            <a href="{{ route('events.show', $event->id) }}" class="mt-auto inline-block text-blue-700 font-semibold hover:underline">{{ __('Learn More') }}</a>
        </div>
        @endforeach
    </div>
</section>

<!-- Latest News Preview -->
<section class="max-w-7xl mx-auto px-6 py-16 bg-gray-50">
    <h2 class="text-3xl font-bold text-blue-900 mb-8 text-center">{{ __('Latest News') }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($news->take(3) as $post)
        <div class="bg-white rounded-lg shadow p-6 flex flex-col">
            <h3 class="text-xl font-semibold mb-2">{{ $post->title }}</h3>
            <p class="text-gray-600 mb-4">{{ \Illuminate\Support\Str::limit($post->body, 120) }}</p>
            <a href="{{ route('news.show', $post->id) }}" class="mt-auto text-blue-700 font-semibold hover:underline">{{ __('Read More') }}</a>
        </div>
        @endforeach
    </div>
</section>

@endsection
