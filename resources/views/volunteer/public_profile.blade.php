@extends('layouts.theme')
@section('title', $volunteer->name ?? 'Volunteer Profile')
@section('content')
<div class="container">
    <div class="dashboard-card p-4 my-4 text-center">
        <img src="{{ $volunteer->profile_photo_url ?? '/default-avatar.png' }}" class="avatar mb-2">
        <h2>{{ $volunteer->name }}</h2>
        <p>{{ $volunteer->bio ?? 'No bio yet.' }}</p>
        <div>
            <span class="badge bg-info">Total Hours: {{ $volunteer->hours ?? 0 }}</span>
            <span class="badge bg-success">Badges: {{ $volunteer->badges_count ?? 0 }}</span>
        </div>
    </div>
</div>
@endsection
