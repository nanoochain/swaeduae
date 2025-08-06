@extends('layouts.app')
@section('title', $certificate->title)
@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-8 max-w-xl mx-auto">
        <h1 class="text-2xl font-bold text-blue-900 mb-4">{{ $certificate->title }}</h1>
        <div class="mb-4 text-gray-600">Issued: {{ $certificate->issue_date }} | Hours: {{ $certificate->hours }}</div>
        <div>{{ $certificate->description }}</div>
        <div class="mt-4 text-gray-500">Certificate Code: <b>{{ $certificate->code }}</b></div>
        @if($certificate->status == 'approved')
        <a href="{{ route('certificates.download', $certificate->id) }}" class="ml-3 text-blue-700 hover:underline">Download PDF</a>
        @endif
    </div>
</div>
@endsection
