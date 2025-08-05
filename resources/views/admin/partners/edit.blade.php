@extends('layouts.admin')
@section('title', 'Edit Partner')
@section('content')
<div class="py-8 px-6">
    <h1 class="text-2xl font-bold mb-6 text-blue-900">Edit Partner</h1>
    <form method="POST" action="{{ route('admin.partners.update', $partner->id) }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow max-w-xl">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="font-bold">Name</label>
            <input type="text" name="name" value="{{ old('name', $partner->name) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="font-bold">Logo</label>
            <input type="file" name="logo" class="w-full border rounded px-3 py-2">
            @if($partner->logo)
                <div class="mt-2">
                    <img src="{{ asset('storage/partners/'.$partner->logo) }}" class="h-12" alt="{{ $partner->name }}">
                </div>
            @endif
        </div>
        <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded font-bold hover:bg-blue-900">Update Partner</button>
    </form>
</div>
@endsection
