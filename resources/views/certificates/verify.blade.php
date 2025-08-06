@extends('layouts.app')
@section('title', 'Verify Certificate')
@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-8 max-w-xl mx-auto">
        <h1 class="text-2xl font-bold mb-4 text-blue-900">Verify Certificate</h1>
        <form method="POST" action="{{ route('certificates.verify') }}">
            @csrf
            <div class="mb-4">
                <label class="block font-bold">Certificate Code</label>
                <input type="text" name="code" class="w-full border rounded px-3 py-2" required>
            </div>
            <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded">Verify</button>
        </form>
    </div>
</div>
@endsection
