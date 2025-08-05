@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4">Users</h1>
    <form class="row mb-3" method="GET" action="">
        <div class="col-md-4">
            <input name="search" class="form-control" placeholder="Search name or email..." value="{{ $search }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Search</button>
        </div>
    </form>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="table-responsive">
        <table class="table table-hover bg-white">
            <thead>
                <tr>
                    <th>Name</th><th>Email</th><th>Role</th><th>Enabled</th><th>Created</th><th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                    <td>{{ $user->role ?? 'Volunteer' }}</td>
                    <td>{!! $user->enabled ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>' !!}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete user?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection
