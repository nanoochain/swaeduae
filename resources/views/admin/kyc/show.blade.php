@extends('layouts.admin_theme')

@section('content')
<h1>KYC Details</h1>

<p>User: {{ $kyc->user->name ?? '' }}</p>
<p>Status: {{ ucfirst($kyc->status) }}</p>
<p>Submitted At: {{ $kyc->created_at->format('Y-m-d') }}</p>
<p>Document: <a href="{{ asset('storage/' . $kyc->document_path) }}" target="_blank">View Document</a></p>

<a href="{{ route('admin.kyc.index') }}">Back to KYC Requests</a>
@endsection
