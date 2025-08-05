@extends('layouts.app')

@section('content')
<div class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-md-7">
                <h1 class="fw-bold display-4 text-primary mb-3">Volunteer. Impact. Connect.</h1>
                <p class="lead mb-4">SawaedUAE is the UAE’s leading platform for volunteers and organizations. Join, discover, and change lives.</p>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">{{ __('Join Now') }}</a>
                <a href="{{ route('volunteer.opportunities') }}" class="btn btn-outline-primary btn-lg">{{ __('View Opportunities') }}</a>
            </div>
            <div class="col-md-5 text-center">
                <img src="{{ asset('hero-volunteer.svg') }}" alt="Hero" class="img-fluid" style="max-width:340px;">
            </div>
        </div>

        <div class="row text-center mb-5">
            <div class="col-4">
                <h3 class="fw-bold text-success">{{ number_format($stats['volunteers']) }}+</h3>
                <div>Volunteers Registered</div>
            </div>
            <div class="col-4">
                <h3 class="fw-bold text-info">{{ number_format($stats['events']) }}+</h3>
                <div>Events Hosted</div>
            </div>
            <div class="col-4">
                <h3 class="fw-bold text-warning">{{ number_format($stats['hours']) }}+</h3>
                <div>Volunteer Hours</div>
            </div>
        </div>

        <h2 class="mb-4 mt-4 fw-bold text-center">{{ __('Featured Opportunities') }}</h2>
        <div class="row g-4">
            @forelse($featured as $opp)
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-2">{{ $opp->title }}</h5>
                            <div class="mb-2 text-muted small">
                                @if($opp->location)
                                    <span><i class="bi bi-geo"></i> {{ $opp->location }}</span>
                                @endif
                            </div>
                            <p class="card-text">{{ Str::limit($opp->description, 70) }}</p>
                        </div>
                        <div class="card-footer bg-white border-0 text-end">
                            <a href="{{ route('volunteer.opportunity.detail', $opp->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col text-center text-muted py-5">
                    <div>{{ __('No upcoming opportunities right now. Please check back soon!') }}</div>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('volunteer.opportunities') }}" class="btn btn-outline-secondary btn-lg">{{ __('See All Opportunities') }}</a>
        </div>
    </div>
</div>
@endsection
