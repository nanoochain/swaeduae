@extends('layouts.app')
@section('title', __('Download Center'))

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-6">{{ __('Downloads & Guidelines') }}</h1>
    <ul class="divide-y divide-gray-200">
        @forelse($files as $file)
            <li class="py-4 flex items-center justify-between">
                <span>{{ $file->name }}</span>
                <a href="{{ asset('downloads/'.$file->path) }}" class="text-green-700 hover:underline font-bold" download>
                    <i class="fa fa-file-pdf"></i> {{ __('Download') }}
                </a>
            </li>
        @empty
            <li class="py-6 text-gray-500">{{ __('No files available.') }}</li>
        @endforelse
    </ul>
</div>
@endsection
