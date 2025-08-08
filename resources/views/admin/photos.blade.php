@extends('layouts.admin_theme')
@section('content')
<div class="max-w-2xl mx-auto mt-10 p-8 bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-6">Logo & Photo Upload</h2>
    <form>
        <label class="block mb-2 font-semibold">Website Logo:</label>
        <input type="file" name="logo" class="mb-4" disabled>
        <label class="block mb-2 font-semibold">Sidebar/Cover Photo:</label>
        <input type="file" name="cover" class="mb-4" disabled>
        <p class="text-gray-400">Upload disabled until backend is connected.</p>
    </form>
</div>
@endsection
