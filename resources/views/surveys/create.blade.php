@extends('layouts.app')
@section('title', 'Event Survey')
@section('content')
<h1>Survey for {{ $event->title }}</h1>
<form method="POST" action="{{ route('surveys.store', $event) }}">
    @csrf
    <label>Question 1: <input type="text" name="responses[q1]" required></label><br/>
    <label>Question 2: <input type="text" name="responses[q2]"></label><br/>
    <button type="submit">Submit Survey</button>
</form>
@endsection
