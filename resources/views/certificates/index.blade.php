@extends('layouts.app')
@section('title', 'My Certificates')
@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-8 max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-4 text-blue-900">My Certificates</h1>
        @if($certificates->isEmpty())
            <p>No certificates yet.</p>
        @else
            <ul>
            @foreach($certificates as $cert)
                <li class="py-3 border-b flex items-center justify-between">
                    <div>
                        <span class="font-semibold">{{ $cert->title }}</span>
                        <span class="text-gray-600">({{ $cert->issue_date }}, {{ $cert->hours }}h)</span>
                        @if($cert->status == 'pending') <span class="text-yellow-600 ml-2">Pending</span> @endif
                        @if($cert->status == 'approved') <span class="text-green-700 ml-2">Approved</span> @endif
                    </div>
                    <div>
                        @if($cert->status == 'approved')
                        <a href="{{ route('certificates.download', $cert->id) }}" class="ml-3 text-blue-700 hover:underline">Download</a>
                        @endif
                        <span class="ml-3 text-gray-400">#{{ $cert->code }}</span>
                    </div>
                </li>
            @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
