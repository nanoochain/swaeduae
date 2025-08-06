@extends('layouts.app')

@section('title', 'Organization Dashboard')

@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-8 max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-blue-900 mb-4">Welcome, {{ \$org->name }}!</h1>
        <a href="{{ route('organization.events.create') }}" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-900 mb-4 inline-block">Create New Event</a>
        <h2 class="font-bold mt-6 mb-2">Your Events</h2>
        <ul>
        @foreach(\$events as \$event)
            <li>
                <span class="font-semibold">{{ \$event->title }}</span>
                <span class="text-gray-500">({{ \$event->date }})</span>
            </li>
        @endforeach
        </ul>
        <h2 class="font-bold mt-6 mb-2">Your Opportunities</h2>
        <ul>
        @foreach(\$opportunities as \$opp)
            <li>
                <span class="font-semibold">{{ \$opp->title }}</span>
                <span class="text-gray-500">({{ \$opp->date }})</span>
            </li>
        @endforeach
        </ul>
    </div>
</div>
@endsection
