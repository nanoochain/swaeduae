@extends('layouts.app')

@section('title', 'Create Event')

@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-8 max-w-xl mx-auto">
        <h1 class="text-2xl font-bold text-blue-900 mb-4">Create Event</h1>
        <form method="POST" action="{{ route('organization.events.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block font-bold">Title</label>
                <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block font-bold">Description</label>
                <textarea name="description" class="w-full border rounded px-3 py-2" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block font-bold">Location</label>
                <input type="text" name="location" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block font-bold">Date</label>
                <input type="date" name="date" class="w-full border rounded px-3 py-2" required>
            </div>
            <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-900">Create Event</button>
        </form>
    </div>
</div>
@endsection
