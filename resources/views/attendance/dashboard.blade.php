@extends('layouts.app')
@section('title', 'Attendance Dashboard')
@section('content')
<h1>Attendance Dashboard</h1>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr><th>User</th><th>Event</th><th>Check-in Time</th><th>Check-out Time</th></tr>
    </thead>
    <tbody>
        @foreach($checkins as $checkin)
        <tr>
            <td>{{ $checkin->user->name }}</td>
            <td>{{ $checkin->event->title }}</td>
            <td>{{ $checkin->checkin_time }}</td>
            <td>{{ $checkin->checkout_time ?? 'N/A' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $checkins->links() }}
@endsection
