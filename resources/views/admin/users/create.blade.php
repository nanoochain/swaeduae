@extends('layouts.admin_theme')

@section('content')
<h1>Create User</h1>

<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf
    <label>Name:</label>
    <input type="text" name="name" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <label>Confirm Password:</label>
    <input type="password" name="password_confirmation" required>

    <label>Admin:</label>
    <input type="checkbox" name="is_admin" value="1">

    <button type="submit">Create</button>
</form>
@endsection
