@extends('layouts.admin')
@section('title', 'News & Announcements')
@section('content')
<div class="py-8 px-6">
    <h1 class="text-2xl font-bold mb-6 text-blue-900">News & Announcements</h1>
    <a href="{{ route('admin.news.create') }}" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-green-700">Add News</a>
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-b">
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Published</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $item->title }}</td>
                        <td class="px-4 py-2">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.news.edit', $item->id) }}" class="text-blue-700 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.news.destroy', $item->id) }}" class="inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete this news?')" class="text-red-700 hover:underline ml-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-gray-400">No news found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
