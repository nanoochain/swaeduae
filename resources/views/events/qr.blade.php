@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-8 flex flex-col items-center">
    <h2 class="text-2xl font-bold mb-4 text-blue-900">Event Check-In</h2>
    @if(isset($event))
        <div class="bg-white shadow p-6 rounded-lg mb-4">
            <div class="mb-2 font-bold">{{ $event->title }}</div>
            <div class="text-gray-600 mb-3">{{ $event->date }}</div>
            <img src="{{ $event->qr_url }}" alt="QR Code" class="mx-auto w-40 h-40 border rounded shadow mb-4">
            <p class="text-gray-700">Scan this QR code at the event venue to check-in!</p>
        </div>
    @else
        <div class="text-gray-600">Event not found.</div>
    @endif
</div>
@endsection
