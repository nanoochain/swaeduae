@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-8 max-w-xl mx-auto">
        <h1 class="text-2xl font-bold text-blue-900 mb-4">Edit Profile</h1>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('POST')
            <div class="mb-4">
                <label class="block font-bold">Name</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ Auth::user()->name }}">
            </div>
            <div class="mb-4">
                <label class="block font-bold">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2" value="{{ Auth::user()->email }}">
            </div>
            <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-900">Save Changes</button>
        </form>
    </div>
</div>
@endsection
