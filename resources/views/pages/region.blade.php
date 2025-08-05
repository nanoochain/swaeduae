@extends('layouts.app')
@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold">Volunteer in {{ ucfirst($region) }}</h1>
    <p class="text-gray-700">Explore volunteering opportunities, initiatives, and events in {{ $region }}.</p>
</div>
@endsection
