@extends('layouts.admin_theme')

@section('content')
<h1>KYC Requests</h1>

<table class="table-auto w-full mt-4">
    <thead>
        <tr>
            <th>ID</th><th>User</th><th>Status</th><th>Submitted At</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kycs as $kyc)
        <tr>
            <td>{{ $kyc->id }}</td>
            <td>{{ $kyc->user->name ?? '' }}</td>
            <td>{{ ucfirst($kyc->status) }}</td>
            <td>{{ $kyc->created_at->format('Y-m-d') }}</td>
            <td>
                <a href="{{ route('admin.kyc.show', $kyc->id) }}" class="text-blue-600">View</a> |
                <form method="POST" action="{{ route('admin.kyc.approve', $kyc->id) }}" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" onclick="return confirm('Approve this KYC?')" class="text-green-600 underline">Approve</button>
                </form> |
                <form method="POST" action="{{ route('admin.kyc.reject', $kyc->id) }}" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" onclick="return confirm('Reject this KYC?')" class="text-red-600 underline">Reject</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $kycs->links() }}

@endsection
