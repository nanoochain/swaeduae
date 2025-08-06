@extends('layouts.app')

@section('title', 'My Certificates')

@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-8 max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-blue-900 mb-4">My Certificates</h1>
        @if(\$certificates->isEmpty())
            <p>No certificates yet.</p>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach(\$certificates as \$cert)
                    <li class="py-4 flex items-center justify-between">
                        <div>
                            <div class="font-bold">{{ \$cert->title }}</div>
                            <div class="text-gray-500 text-sm">Issued: {{ \$cert->issue_date }} | Hours: {{ \$cert->hours }}</div>
                        </div>
                        <a href="{{ route('volunteer.certificates.show', \$cert->id) }}" class="text-blue-700 hover:underline">View</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
