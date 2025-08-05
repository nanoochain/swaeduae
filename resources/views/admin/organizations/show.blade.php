@extends('layouts.admin')
@section('title', 'Organization Details')
@section('content')
<div class="py-8 px-6">
    <h1 class="text-2xl font-bold mb-4 text-blue-800">Organization Details</h1>
    <div class="bg-white p-6 rounded shadow max-w-xl">
        <div><strong>ID:</strong> {{ $organization->id }}</div>
        <div><strong>Name:</strong> {{ $organization->name }}</div>
        <div><strong>Email:</strong> {{ $organization->email }}</div>
        <div><strong>Status:</strong>
            @if($organization->status == 'active')
                <span class="text-green-700 font-bold">Active</span>
            @else
                <span class="text-gray-500">Pending</span>
            @endif
        </div>
        <div><strong>Created:</strong> {{ $organization->created_at->format('d M Y H:i') }}</div>
        <a href="{{ route('admin.organizations.edit', $organization->id) }}" class="bg-yellow-600 text-white px-4 py-2 rounded mt-4 inline-block hover:bg-yellow-700">Edit Organization</a>
    </div>
</div>
@endsection
