@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h2 class="text-3xl font-bold mb-4">Welcome, {{ Auth::user()->name }}</h2>

    <div class="grid md:grid-cols-4 gap-4 mb-8">
        <div class="stat-box">
            <div class="stat-number">{{ $hours ?? 0 }}</div>
            <div class="stat-label">Volunteer Hours</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $events ?? 0 }}</div>
            <div class="stat-label">Events Attended</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $certificates ?? 0 }}</div>
            <div class="stat-label">Certificates</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $badges ?? 0 }}</div>
            <div class="stat-label">Badges Earned</div>
        </div>
    </div>

    <div class="bg-white rounded p-4 mb-8">
        <h3>My Next Event</h3>
        @if($nextEvent)
        <p><strong>{{ $nextEvent->title }}</strong> on {{ $nextEvent->date }}</p>
        @else
        <p>No upcoming events.</p>
        @endif
    </div>

    <a href="{{ route('volunteer.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
    <a href="{{ route('certificates.index') }}" class="btn btn-secondary">View Certificates</a>
</div>
@endsection
