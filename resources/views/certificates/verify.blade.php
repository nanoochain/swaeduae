@extends('layouts.app')
@section('content')
<div class="container py-5 text-center">
    <div class="card shadow p-5 mx-auto" style="max-width: 500px;">
        <h2 class="fw-bold text-success mb-4">Certificate Verified</h2>
        <p>This certificate is valid and was issued to:</p>
        <h4 class="mb-3">{{ $cert->user->name }}</h4>
        <p>For completing: <strong>{{ $cert->opportunity->title ?? 'Volunteering' }}</strong></p>
        <p class="mb-2"><b>Date Issued:</b> {{ $cert->issued_at->format('d M Y') }}</p>
        <div class="alert alert-info">Certificate #: <b>{{ $cert->certificate_number }}</b></div>
        <a href="{{ url('/') }}" class="btn btn-outline-primary mt-3">Back to Home</a>
    </div>
</div>
@endsection
