@extends('layouts.app')

@section('title', $opportunity->title . ' | Volunteer Opportunity')

@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-8 max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-blue-900 mb-2">{{ $opportunity->title }}</h1>
        <div class="mb-3 text-gray-600">{{ $opportunity->location }} | {{ $opportunity->date }}</div>
        <p class="mb-4">{{ $opportunity->description }}</p>
        <a href="{{ route('opportunities.index') }}" class="text-blue-700 hover:underline">← Back to Opportunities</a>
    </div>
</div>
@endsection
