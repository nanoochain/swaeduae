@extends('layouts.app')

@section('title', \$certificate->title)

@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-8 max-w-xl mx-auto">
        <h1 class="text-2xl font-bold text-blue-900 mb-4">{{ \$certificate->title }}</h1>
        <p>{{ \$certificate->description }}</p>
        <div class="mb-4 text-gray-600">Issued: {{ \$certificate->issue_date }} | Hours: {{ \$certificate->hours }}</div>
        <a href="{{ route('volunteer.certificates') }}" class="text-blue-700 hover:underline">← Back to Certificates</a>
        @if(\$certificate->pdf)
            <a href="{{ asset('storage/' . \$certificate->pdf) }}" target="_blank" class="ml-3 text-green-700 hover:underline">Download PDF</a>
        @endif
    </div>
</div>
@endsection
