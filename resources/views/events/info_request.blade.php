@extends('layouts.app')
@section('title', 'Event Information Request')
@section('content')
<h1>Information Request for {{ $event->title }}</h1>
@if($infoRequest)
<form method="POST" action="{{ route('events.info_request.submit', $event) }}">
    @csrf
    @foreach($infoRequest->form_fields as $field)
        <label>{{ $field['label'] }}:
            <input type="{{ $field['type'] ?? 'text' }}" name="{{ $field['name'] }}" required="{{ $field['required'] ?? false }}">
        </label><br/>
    @endforeach
    <button type="submit">Submit</button>
</form>
@else
<p>No additional information requested for this event.</p>
@endif
@endsection
