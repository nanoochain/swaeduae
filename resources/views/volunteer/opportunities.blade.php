@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold mb-6">Volunteer Opportunities</h1>

    @if($opportunities->count())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($opportunities as $opportunity)
                <div class="bg-white shadow rounded p-4">
                    <h2 class="text-xl font-bold mb-2">{{ $opportunity->title }}</h2>
                    <p class="mb-2">{{ Str::limit($opportunity->description, 120) }}</p>
                    <p class="text-sm text-gray-600 mb-2">{{ __('Date:') }} {{ \Carbon\Carbon::parse($opportunity->date)->format('M d, Y') }}</p>
                    <p class="text-sm text-gray-600 mb-2">{{ __('Location:') }} {{ $opportunity->location ?? __('Online') }}</p>
                    <a href="{{ route('volunteer.opportunities.show', $opportunity->id) }}" class="text-blue-700 hover:underline">View Details</a>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $opportunities->links() }}
        </div>
    @else
        <p>No upcoming opportunities right now. Please check back soon!</p>
    @endif
@endsection
