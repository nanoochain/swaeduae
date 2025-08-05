@extends('layouts.admin')
@section('title', 'Manage News')
@section('content')
<div class="py-8 px-6">
    <h1 class="text-2xl font-bold mb-6 text-blue-800">Manage News</h1>
    <a href="{{ route('admin.news.create') }}" class="bg-blue-700 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-900">Add News Article</a>
    <table class="min-w-full table-auto bg-white rounded shadow">
        <thead>
            <tr>
                <th>ID</th><th>Title</th><th>Published</th><th>Status</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($news as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}</td>
                    <td>
                        @if($item->status == 'published')
                            <span class="text-green-700 font-bold">Published</span>
                        @else
                            <span class="text-gray-500">Draft</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.news.edit', $item->id) }}" class="text-yellow-700 underline">Edit</a>
                        <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete news?')" class="text-red-700 underline ml-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-gray-400">No news articles found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
