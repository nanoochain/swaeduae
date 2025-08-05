@extends('layouts.app')
@section('title', 'Event Evaluation')
@section('content')
<h1>Evaluate {{ $event->title }}</h1>
<form method="POST" action="{{ route('events.evaluation.store', $event) }}">
    @csrf
    <label>Rating (1-5): <input type="number" name="rating" min="1" max="5" required></label><br/>
    <label>Comments:<br/><textarea name="comments"></textarea></label><br/>
    <label>Reflection:<br/><textarea name="reflection" required></textarea></label><br/>
    <button type="submit">Submit Evaluation</button>
</form>
@endsection
