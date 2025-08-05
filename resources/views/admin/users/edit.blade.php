@extends('layouts.app')
@section('content')
<div class="container py-5" style="max-width: 520px;">
    <h1 class="fw-bold mb-4">Edit User</h1>
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control">
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="volunteer" {{ $user->role === 'volunteer' ? 'selected' : '' }}>Volunteer</option>
                <option value="org" {{ $user->role === 'org' ? 'selected' : '' }}>Organization</option>
            </select>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="enabled" value="1" class="form-check-input" id="enabled" {{ $user->enabled ? 'checked' : '' }}>
            <label for="enabled" class="form-check-label">Enabled</label>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-link">Cancel</a>
    </form>
</div>
@endsection
