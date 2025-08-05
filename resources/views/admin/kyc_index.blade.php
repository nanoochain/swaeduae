@extends('layouts.app')
@section('title', 'Admin KYC Review')
@section('content')
<h1>KYC Review</h1>
@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>User ID</th>
            <th>Document</th>
            <th>Status</th>
            <th>Update Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kycRequests as $kyc)
        <tr>
            <td>{{ $kyc->user_id }}</td>
            <td><a href="{{ Storage::url($kyc->document_path) }}" target="_blank">View Document</a></td>
            <td>{{ ucfirst($kyc->status) }}</td>
            <td>
                <form method="POST" action="{{ route('admin.kyc.updateStatus', $kyc) }}">
                    @csrf
                    <select name="status">
                        <option value="pending" {{ $kyc->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $kyc->status == 'approved' ? 'selected' : '' }}>Approve</option>
                        <option value="rejected" {{ $kyc->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
