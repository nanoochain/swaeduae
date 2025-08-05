@extends('layouts.admin')
@section('title', 'User Details')
@section('content')
<div class="py-8 px-6">
    <h1 class="text-2xl font-bold mb-4 text-blue-800">User Details</h1>
    <div class="bg-white p-6 rounded shadow max-w-xl">
        <div><strong>ID:</strong> {{ $user->id }}</div>
        <div><strong>Name:</strong> {{ $user->name }}</div>
        <div><strong>Email:</strong> {{ $user->email }}</div>
        <div><strong>Role:</strong> {{ ucfirst($user->role) }}</div>
        <div><strong>Status:</strong>
            @if($user->status == 'active')
                <span class="text-green-700 font-bold">Active</span>
            @else
                <span class="text-gray-500">Pending</span>
            @endif
        </div>
        <div><strong>Registered:</strong> {{ $user->created_at->format('d M Y H:i') }}</div>
        <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-600 text-white px-4 py-2 rounded mt-4 inline-block hover:bg-yellow-700">Edit User</a>
    </div>
</div>
@endsection
