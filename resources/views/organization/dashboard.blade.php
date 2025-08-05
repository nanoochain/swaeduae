@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Organization Dashboard</h2>
    <p>Welcome, {{ $org->name }}</p>
    <a href="{{ route('events.create') }}">Create Event</a> |
    <a href="{{ route('organization.logout') }}">Logout</a>
    <h3>Your Events</h3>
    <ul>
        @foreach($events as $event)
        <li>{{ $event->title }} on {{ $event->date }}</li>
        @endforeach
    </ul>
</div>
@endsection
