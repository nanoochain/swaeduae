@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Upcoming Events</h1>
    @if ($events->count())
        <ul>
            @foreach ($events as $event)
                <li class="mb-4">
                    <a href="{{ route('events.show', $event->id) }}" class="text-blue-700 hover:underline text-lg font-semibold">
                        {{ $event->title }}
                    </a>
                    <p class="text-gray-600">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</p>
                </li>
            @endforeach
        </ul>
        {{ $events->links() }}
    @else
        <p>No upcoming events found.</p>
    @endif
</div>
@endsection
