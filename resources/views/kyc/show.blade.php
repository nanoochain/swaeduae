@extends('layouts.app')
@section('title', 'KYC Upload')
@section('content')
<h1>KYC Upload</h1>
@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif
@if ($kyc)
    <p>Status: {{ ucfirst($kyc->status) }}</p>
    <p>Document: <a href="{{ Storage::url($kyc->document_path) }}" target="_blank">View</a></p>
@else
    <p>You have not uploaded any KYC document yet.</p>
@endif
<form method="POST" action="{{ route('kyc.upload') }}" enctype="multipart/form-data">
    @csrf
    <label>Upload Document (PDF, JPG, PNG): <input type="file" name="document" required></label><br/>
    <button type="submit">Upload</button>
</form>
@endsection
