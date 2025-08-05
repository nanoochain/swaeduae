@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4 text-primary">Volunteer Events</h1>
    @include('partials.events-list', ['events' => $events ?? collect() ])
</div>
@endsection
