@extends('layouts.admin')
@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold mb-6">Edit Event</h1>
    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" class="bg-white p-6 rounded shadow max-w-lg">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Title</label>
            <input name="title" class="form-control" value="{{ old('title', $event->title) }}" required>
        </div>
        <div class="mb-3">
            <label>Date</label>
            <input name="date" type="date" class="form-control" value="{{ old('date', $event->date) }}" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required>{{ old('description', $event->description) }}</textarea>
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
