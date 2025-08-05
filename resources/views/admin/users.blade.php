@extends('layouts.app')
@section('title', 'Manage Users')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-8">Users</h1>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-3 py-2">ID</th>
                <th class="border border-gray-300 px-3 py-2">Name</th>
                <th class="border border-gray-300 px-3 py-2">Email</th>
                <th class="border border-gray-300 px-3 py-2">Role</th>
                <th class="border border-gray-300 px-3 py-2">Active</th>
                <th class="border border-gray-300 px-3 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <td class="border border-gray-300 px-3 py-2">{{ $u->id }}</td>
                <td class="border border-gray-300 px-3 py-2">{{ $u->name }}</td>
                <td class="border border-gray-300 px-3 py-2">{{ $u->email }}</td>
                <td class="border border-gray-300 px-3 py-2">{{ $u->role }}</td>
                <td class="border border-gray-300 px-3 py-2">{{ $u->active ? 'Yes' : 'No' }}</td>
                <td class="border border-gray-300 px-3 py-2">
                    <form method="POST" action="{{ route('admin.users.toggle', $u->id) }}">
                        @csrf
                        <button type="submit" class="text-blue-600 hover:underline">{{ $u->active ? 'Deactivate' : 'Activate' }}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
