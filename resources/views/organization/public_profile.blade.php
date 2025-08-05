@extends('layouts.theme')
@section('title', $
@section('content')
<div
    <div class="d
        <img s
        <h2>{{ $org->
        <p>{{ $org->description ?? 'No description yet.' }}</p>
        <div>
            <span class="badge bg-info">Total Events: {{ $org->events_count ?? 0 }}</span>
            <span class="badge bg-success">Volunteers: {{ $org->volunteers_count ?? 0 }}</span>
        </div>
    </div>
</div>
@endsection
