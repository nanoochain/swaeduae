@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4 text-primary">{{ __('messages.about') }}</h1>
    <div class="card shadow-sm border-0 p-4">
        <p>
            Sawaed UAE is a national volunteer platform connecting individuals and organizations with impactful opportunities across the UAE.<br>
            <b>Our Mission:</b> Empowering the community through volunteering, skill development, and social impact.
        </p>
        <ul class="mt-3">
            <li>Find volunteer events by region, cause, or skill.</li>
            <li>Track your volunteer hours and certificates.</li>
            <li>Organizations can post events and recruit volunteers.</li>
        </ul>
        <p class="mt-3">Join us in building a better, stronger UAE – together!</p>
    </div>
</div>
@endsection
