@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Volunteer Profile</h2>
    <p>Name: {{ auth()->user()->name }}</p>
    <p>Email: {{ auth()->user()->email }}</p>
    <p>Phone: {{ $volunteer->phone ?? 'N/A' }}</p>
    <p>KYC Status: {{ ucfirst($volunteer->kyc_status) }}</p>
</div>
@endsection
