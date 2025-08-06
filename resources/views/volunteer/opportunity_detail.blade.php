@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">{{ $opp->title ?? 'Untitled Opportunity' }}</h1>
    <div class="mb-4">
        <strong>Description:</strong>
        <p>{{ $opp->description ?? 'No description.' }}</p>
    </div>
    <div class="mb-2">
        <strong>Date:</strong> {{ $opp->date ?? 'N/A' }}
    </div>
    <div class="mb-2">
        <strong>Location:</strong> {{ $opp->location ?? 'N/A' }}
    </div>
    <a href="{{ route('opportunities.index') }}" class="text-blue-600 underline">&larr; Back to all opportunities</a>
@endsection
