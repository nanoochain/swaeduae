@extends('layouts.app')
@section('title', __('News & Updates'))

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-6">{{ __('Latest News') }}</h1>
    @forelse($news as $post)
        <div class="mb-6 bg-white p-5 rounded shadow">
            <div class="text-xs text-gray-400 mb-2">{{ $post->created_at->format('d M Y') }}</div>
            <h2 class="font-bold text-lg mb-2">{{ $post->title }}</h2>
            <div class="text-gray-700 mb-2">{{ Str::limit($post->body, 180) }}</div>
            <a href="{{ route('news.show', $post->id) }}" class="text-blue-700 font-bold hover:underline">{{ __('Read More') }}</a>
        </div>
    @empty
        <div class="text-gray-500">{{ __('No news yet.') }}</div>
    @endforelse
</div>
@endsection
