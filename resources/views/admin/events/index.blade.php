@extends('layouts.admin')

@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold mb-6">Manage Events</h1>
    <a href="{{ route('admin.events.create') }}" class="btn btn-success mb-4">Add New Event</a>
    <table class="table table-bordered bg-white shadow-sm">
        <thead>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d') }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($event->description, 50) }}</td>
                    <td>
                        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete event?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No events found.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $events->links() }}
</div>
@endsection
