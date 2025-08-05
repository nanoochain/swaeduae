@extends('layouts.app')
@section('content')
<div class="container">
    <h2>My Volunteer Dashboard</h2>
    <p>Name: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    <h4>My Events</h4>
    <ul>
        @foreach($events ?? [] as $event)
            <li>{{ $event->title ?? '' }} ({{ $event->date ?? '' }})</li>
        @endforeach
    </ul>
    <h4>My Certificates</h4>
    <ul>
        @foreach($certificates as $cert)
            <li>Certificate #{{ $cert->id }} for event #{{ $cert->event_id }}</li>
        @endforeach
    </ul>
</div>
@endsection
