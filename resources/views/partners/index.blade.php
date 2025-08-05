@extends('layouts.app')
@section('title', __('Our Partners'))

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-6">{{ __('Strategic Partners & Organizations') }}</h1>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($partners as $p)
            <div class="flex flex-col items-center bg-white rounded-lg shadow p-4">
                <img src="{{ asset('partners/' . $p->logo) }}" class="w-20 h-20 object-contain mb-2" alt="{{ $p->name }}">
                <div class="font-bold">{{ $p->name }}</div>
            </div>
        @endforeach
    </div>
</div>
@endsection
