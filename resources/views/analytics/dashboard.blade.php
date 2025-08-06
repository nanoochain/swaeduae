@extends('layouts.app')
@section('title', 'Platform Analytics')
@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-8 max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-blue-900 mb-4">Platform Analytics</h1>
        <ul>
            <li>Total Volunteers: <b>{{ $volunteers }}</b></li>
            <li>Total Organizations: <b>{{ $organizations }}</b></li>
            <li>Total Events: <b>{{ $events }}</b></li>
            <li>Total Opportunities: <b>{{ $opportunities }}</b></li>
            <li>Total Certificates: <b>{{ $certificates }}</b></li>
            <li>Total Volunteer Hours: <b>{{ $hours }}</b></li>
        </ul>
        <div class="mt-8">
            <a href="{{ route('home') }}" class="text-blue-700 hover:underline">← Back to Home</a>
        </div>
    </div>
</div>
@endsection
