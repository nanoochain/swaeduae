@extends('layouts.app')
@section('title', $news->title . ' | News | SawaedUAE')

@section('content')
<div class="max-w-2xl mx-auto py-10">
    <h1 class="text-3xl font-bold text-blue-800 mb-2">{{ $news->title }}</h1>
    <p class="text-gray-500 text-sm mb-4">{{ $news->created_at->format('d M Y') }}</p>
    <div class="prose max-w-none">
        {!! nl2br(e($news->content)) !!}
    </div>
    <a href="{{ route('news.index') }}" class="mt-8 inline-block text-blue-600 hover:underline">&larr; Back to News</a>
</div>
@endsection
