@extends('layouts.admin')
@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold mb-6">Add Event</h1>
    <form action="{{ route('admin.events.store') }}" method="POST" class="bg-white p-6 rounded shadow max-w-lg">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Date</label>
            <input name="date" type="date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <button class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
