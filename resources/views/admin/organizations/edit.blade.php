@extends('layouts.admin')
@section('title', 'Edit Organization')
@section('content')
<div class="py-8 px-6">
    <h1 class="text-2xl font-bold mb-4 text-blue-800">Edit Organization</h1>
    <form method="POST" action="{{ route('admin.organizations.update', $organization->id) }}" class="bg-white p-6 rounded shadow max-w-xl">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="font-bold">Name</label>
            <input type="text" name="name" value="{{ old('name', $organization->name) }}" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="font-bold">Email</label>
            <input type="email" name="email" value="{{ old('email', $organization->email) }}" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="font-bold">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="active" @if($organization->status == 'active') selected @endif>Active</option>
                <option value="pending" @if($organization->status == 'pending') selected @endif>Pending</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded font-bold hover:bg-blue-900">Update Organization</button>
    </form>
</div>
@endsection
