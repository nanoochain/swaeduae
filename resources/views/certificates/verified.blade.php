@extends('layouts.app')
@section('title', 'Certificate Verification')
@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-8 max-w-xl mx-auto">
        @if(isset($certificate))
            <h1 class="text-2xl font-bold mb-4 text-green-800">Valid Certificate</h1>
            <div class="mb-3">Holder: <b>{{ $certificate->user->name }}</b></div>
            <div>Title: {{ $certificate->title }}</div>
            <div>Date: {{ $certificate->issue_date }}</div>
            <div>Hours: {{ $certificate->hours }}</div>
            <div>Certificate Code: {{ $certificate->code }}</div>
        @else
            <h1 class="text-2xl font-bold mb-4 text-red-800">Invalid Certificate</h1>
            <div>{{ $error ?? 'Certificate not found.' }}</div>
        @endif
    </div>
</div>
@endsection
