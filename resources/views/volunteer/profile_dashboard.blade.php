@extends('layouts.app')
@section('title', 'Volunteer Profile')
@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-8 max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-blue-900 mb-4">Volunteer Profile</h1>
        <div class="mb-4">
            <strong>Name:</strong> {{ \$user->name }}<br>
            <strong>Email:</strong> {{ \$user->email }}<br>
            <strong>Total Volunteer Hours:</strong> {{ \$hours }}
        </div>
        <h2 class="text-xl font-semibold mt-6 mb-2">Registered Events</h2>
        <ul>
        @forelse(\$events as \$event)
            <li>
                <span class="font-semibold">{{ \$event->title }}</span>
                <span class="text-gray-500">({{ \$event->date }})</span>
            </li>
        @empty
            <li>No registered events yet.</li>
        @endforelse
        </ul>
        <h2 class="text-xl font-semibold mt-6 mb-2">Certificates</h2>
        <ul>
        @forelse(\$certificates as \$cert)
            <li>
                <a href="{{ route('certificates.show', \$cert->id) }}" class="text-blue-700 hover:underline">{{ \$cert->title }}</a>
                @if(\$cert->status == 'pending') <span class="text-yellow-700">Pending</span> @endif
                @if(\$cert->status == 'approved') <span class="text-green-700">Approved</span> @endif
            </li>
        @empty
            <li>No certificates issued yet.</li>
        @endforelse
        </ul>
    </div>
</div>
@endsection
