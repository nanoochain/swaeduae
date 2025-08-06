@extends('layouts.app')

@section('title', 'Volunteer Opportunities | SawaedUAE')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white shadow rounded-lg p-8">
        <h1 class="text-3xl font-bold text-blue-900 mb-6">Volunteer Opportunities</h1>
        @if($opportunities->count() == 0)
            <p>No volunteer opportunities found.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($opportunities as $opp)
                    <div class="bg-blue-50 p-6 rounded shadow">
                        <h2 class="text-xl font-bold mb-2">{{ $opp->title }}</h2>
                        <p class="mb-1">{{ $opp->description }}</p>
                        <div class="mb-2 text-gray-500 text-sm">{{ $opp->location }} | {{ $opp->start_date }}</div>
                        <a href="{{ route('opportunities.show', $opp->id) }}" class="text-blue-700 hover:underline font-semibold">View Details</a>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $opportunities->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
