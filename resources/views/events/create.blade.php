@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Create New Event</h2>
    <form method="POST" action="{{ route('events.store') }}">
        @csrf
        <div><label>Title:</label><input type="text" name="title"></div>
        <div><label>Description:</label><textarea name="description"></textarea></div>
        <div><label>Location:</label><input type="text" name="location"></div>
        <div><label>Date:</label><input type="date" name="date"></div>
        <div><label>Hours:</label><input type="number" name="hours" min="1" value="1"></div>
        <button type="submit">Create Event</button>
    </form>
</div>
@endsection
