@extends('layouts.app')

@section('content')
<h1>KYC Verification</h1>

@if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
@endif

@if($kyc)
    <p>Status: {{ ucfirst($kyc->status) }}</p>
    <p>Document: <a href="{{ asset('storage/' . $kyc->document_path) }}" target="_blank">View Uploaded Document</a></p>
@else
    <p>You have not uploaded any KYC documents yet.</p>
@endif

<form action="{{ route('kyc.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="document">Upload KYC Document (PDF, JPG, PNG):</label><br/>
    <input type="file" name="document" id="document" required><br/><br/>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Upload</button>
</form>

@endsection
