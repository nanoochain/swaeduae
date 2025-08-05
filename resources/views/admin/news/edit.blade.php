@extends('layouts.admin')
@section('title', 'Edit News')
@section('content')
<div class="py-8 px-6">
    <h1 class="text-2xl font-bold mb-6 text-blue-900">Edit News</h1>
    <form method="POST" action="{{ route('admin.news.update', $news->id) }}" class="bg-white p-6 rounded shadow max-w-xl">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="font-bold">Title</label>
            <input type="text" name="title" value="{{ old('title', $news->title) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="font-bold">Content</label>
            <textarea name="content" class="w-full border rounded px-3 py-2" rows="5" required>{{ old('content', $news->content) }}</textarea>
        </div>
        <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded font-bold hover:bg-blue-900">Update News</button>
    </form>
</div>
@endsection
