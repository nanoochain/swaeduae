@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 font-bold text-2xl text-blue-900">Create Opportunity</h2>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('admin.opportunities.store') }}" class="bg-white shadow p-4 rounded max-w-lg">
        @csrf
        <div class="mb-3">
            <label class="block font-bold mb-1">Title</label>
            <input type="text" name="title" class="w-full border rounded px-3 py-2" required value="{{ old('title') }}">
        </div>
        <div class="mb-3">
            <label class="block font-bold mb-1">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2" required>{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="block font-bold mb-1">Location</label>
            <input type="text" name="location" class="w-full border rounded px-3 py-2" required value="{{ old('location') }}">
        </div>
        <div class="mb-3">
            <label class="block font-bold mb-1">Date</label>
            <input type="date" name="date" class="w-full border rounded px-3 py-2" required value="{{ old('date') }}">
        </div>
        <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-900">Add Opportunity</button>
    </form>
</div>
@endsection
