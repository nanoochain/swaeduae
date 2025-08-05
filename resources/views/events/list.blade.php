@extends('layouts.app')
@section('content')
<div class="container">
    <h1>All Events</h1>
    <ul>
        @foreach($events as $event)
            <li><a href="{{ route('events.show', $event->id) }}">{{ $event->title }}</a></li>
        @endforeach
    </ul>
</div>
@endsection
