@extends('admin.layout')

@section('content')
<h1>Event Details</h1>

<p>Title: {{ $event->title ?? '' }}</p>
<p>Description: {{ $event->description ?? '' }}</p>

<a href="{{ route('admin.events.edit', $event->id ?? '') }}">Edit</a>
<a href="{{ route('admin.events.index') }}">Back to List</a>
@endsection
