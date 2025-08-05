@extends('layouts.app')
@section('title', 'Manage Events')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-8">Events</h1>
    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-3 py-2">ID</th>
                <th class="border border-gray-300 px-3 py-2">Title</th>
                <th class="border border-gray-300 px-3 py-2">City</th>
                <th class="border border-gray-300 px-3 py-2">Date</th>
                <th class="border border-gray-300 px-3 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $e)
            <tr>
                <td class="border border-gray-300 px-3 py-2">{{ $e->id }}</td>
                <td class="border border-gray-300 px-3 py-2">{{ $e->title }}</td>
                <td class="border border-gray-300 px-3 py-2">{{ $e->city }}</td>
                <td class="border border-gray-300 px-3 py-2">{{ $e->date ?? 'N/A' }}</td>
                <td class="border border-gray-300 px-3 py-2">{{ ucfirst($e->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $events->links() }}</div>
</div>
@endsection
