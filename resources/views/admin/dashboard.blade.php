@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-8 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-blue-900 mb-4">Admin Dashboard</h1>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-blue-100 p-4 rounded shadow">
                <div class="text-lg">Total Volunteers</div>
                <div class="text-2xl font-bold">{{ $volunteers }}</div>
            </div>
            <div class="bg-green-100 p-4 rounded shadow">
                <div class="text-lg">Organizations</div>
                <div class="text-2xl font-bold">{{ $organizations }}</div>
            </div>
            <div class="bg-purple-100 p-4 rounded shadow">
                <div class="text-lg">Events</div>
                <div class="text-2xl font-bold">{{ $events }}</div>
            </div>
            <div class="bg-yellow-100 p-4 rounded shadow">
                <div class="text-lg">Opportunities</div>
                <div class="text-2xl font-bold">{{ $opportunities }}</div>
            </div>
            <div class="bg-pink-100 p-4 rounded shadow">
                <div class="text-lg">Certificates</div>
                <div class="text-2xl font-bold">{{ $certificates }}</div>
            </div>
        </div>
        <h2 class="font-bold mb-2">Pending Volunteers</h2>
        <ul>
        @foreach($pendingVolunteers as $pending)
            <li class="flex items-center mb-2">
                <span class="mr-4">{{ $pending->name }} ({{ $pending->email }})</span>
                <form method="POST" action="{{ route('admin.volunteers.approve', $pending->id) }}" class="mr-2">@csrf<button class="bg-green-600 text-white px-2 py-1 rounded">Approve</button></form>
                <form method="POST" action="{{ route('admin.volunteers.reject', $pending->id) }}">@csrf<button class="bg-red-600 text-white px-2 py-1 rounded">Reject</button></form>
            </li>
        @endforeach
        </ul>
    </div>
</div>
@endsection
