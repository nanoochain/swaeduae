@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-blue-800">{{ $opportunity->title }}</h1>
    <p class="text-gray-600">{{ $opportunity->region }} | {{ $opportunity->location }}</p>
    <p class="my-4">{{ $opportunity->description }}</p>
    <p><strong>Start:</strong> {{ $opportunity->start_date }} | <strong>End:</strong> {{ $opportunity->end_date }}</p>
    <a href="#" class="mt-4 inline-block bg-blue-700 text-white px-4 py-2 rounded">Apply Now</a>
</div>
@endsection
