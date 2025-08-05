@extends('layouts.admin')
@section('title', 'Manage Organizations')
@section('content')
<div class="py-8 px-6">
    <h1 class="text-2xl font-bold mb-6 text-blue-800">Manage Organizations</h1>
    <table class="min-w-full table-auto bg-white rounded shadow">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Status</th><th>Created</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($organizations as $org)
                <tr>
                    <td>{{ $org->id }}</td>
                    <td>{{ $org->name }}</td>
                    <td>{{ $org->email }}</td>
                    <td>
                        @if($org->status == 'active')
                            <span class="text-green-700 font-bold">Active</span>
                        @else
                            <span class="text-gray-500">Pending</span>
                        @endif
                    </td>
                    <td>{{ $org->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.organizations.show', $org->id) }}" class="text-blue-700 underline">View</a>
                        <form action="{{ route('admin.organizations.destroy', $org->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete organization?')" class="text-red-700 underline ml-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-gray-400">No organizations found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
