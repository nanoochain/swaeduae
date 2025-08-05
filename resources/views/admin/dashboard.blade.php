@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow rounded p-6 text-center">
            <h2 class="text-xl font-semibold">Registered Users</h2>
            <p class="text-4xl font-extrabold text-blue-700">{{ $users }}</p>
        </div>
        <div class="bg-white shadow rounded p-6 text-center">
            <h2 class="text-xl font-semibold">Events</h2>
            <p class="text-4xl font-extrabold text-green-700">{{ $events }}</p>
        </div>
        <div class="bg-white shadow rounded p-6 text-center">
            <h2 class="text-xl font-semibold">Certificates Issued</h2>
            <p class="text-4xl font-extrabold text-purple-700">{{ $certs }}</p>
        </div>
    </div>
    <div>
        <h2 class="text-2xl font-semibold mb-4">Recent Logs</h2>
        <pre class="bg-gray-100 rounded p-4 max-h-48 overflow-auto text-xs">{{ $logs }}</pre>
    </div>
    <form method="POST" action="{{ route('admin.backup') }}" class="mt-6">
        @csrf
        <button type="submit" class="bg-yellow-600 hover:bg-yellow-800 text-white px-4 py-2 rounded font-bold">
            Trigger Manual Backup
        </button>
    </form>
</div>
@endsection
