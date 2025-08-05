@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-3xl font-bold mb-4">{{ $event->title }}</h1>
    <p class="text-gray-600 mb-2">{{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</p>
    <div class="mb-6">
        {!! nl2br(e($event->description)) !!}
    </div>
    <a href="{{ route('events.index') }}" class="text-blue-700 hover:underline">Back to events</a>
</div>
@endsection
