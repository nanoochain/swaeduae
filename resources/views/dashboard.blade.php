@extends('layouts.app')
@section('title', __('Volunteer Dashboard'))

@section('content')
@include('partials.notifications')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-4">{{ __('Dashboard') }}</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Example Widget -->
        <div class="bg-white p-4 rounded shadow text-center">
            <div class="text-blue-600 text-3xl mb-2"><i class="fa fa-hourglass-half"></i></div>
            <div class="font-bold text-xl">{{ $hours ?? 0 }}</div>
            <div class="text-gray-500">{{ __('Volunteer Hours') }}</div>
        </div>
        <!-- Add more widgets here -->
    </div>
</div>
@endsection
