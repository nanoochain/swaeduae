@extends('layouts.admin_theme')
@section('content')
<div class="max-w-lg mx-auto mt-10 p-8 bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-6">Edit User</h2>
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="border px-4 py-2 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="border px-4 py-2 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Role</label>
            <input type="text" name="role" value="{{ $user->role }}" class="border px-4 py-2 w-full rounded">
        </div>
        <button class="bg-blue-600 text-white px-6 py-2 rounded">Update</button>
        <a href="{{ route('admin.users.index') }}" class="ml-4 text-gray-600">Cancel</a>
    </form>
</div>
@endsection
