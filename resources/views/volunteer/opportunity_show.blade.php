@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold mb-4">{{ $opportunity->title }}</h1>

    <div class="bg-white p-6 rounded shadow mb-6">
        <p>{{ $opportunity->description }}</p>
        <p><strong>{{ __('Date:') }}</strong> {{ \Carbon\Carbon::parse($opportunity->date)->format('M d, Y') }}</p>
        <p><strong>{{ __('Location:') }}</strong> {{ $opportunity->location ?? __('Online') }}</p>
        <p><strong>{{ __('Status:') }}</strong> {{ ucfirst($opportunity->status) }}</p>
    </div>

    <a href="{{ route('opportunities.index') }}" class="text-blue-700 hover:underline">&larr; Back to Opportunities</a>
@endsection
