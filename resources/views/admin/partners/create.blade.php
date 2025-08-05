@extends('layouts.admin')
@section('title', 'Add Partner')
@section('content')
<div class="py-8 px-6">
    <h1 class="text-2xl font-bold mb-6 text-blue-900">Add Partner</h1>
    <form method="POST" action="{{ route('admin.partners.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow max-w-xl">
        @csrf
        <div class="mb-4">
            <label class="font-bold">Name</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="font-bold">Logo</label>
            <input type="file" name="logo" class="w-full border rounded px-3 py-2" required>
        </div>
        <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded font-bold hover:bg-green-900">Add Partner</button>
    </form>
</div>
@endsection
