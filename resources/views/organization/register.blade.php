@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Register Organization</h2>
    <form method="POST" action="{{ route('organization.register') }}">
        @csrf
        <div><label>Name:</label><input type="text" name="name"></div>
        <div><label>Email:</label><input type="email" name="email"></div>
        <div><label>Address:</label><input type="text" name="address"></div>
        <div><label>Password:</label><input type="password" name="password"></div>
        <div><label>Confirm Password:</label><input type="password" name="password_confirmation"></div>
        <button type="submit">Register</button>
    </form>
</div>
@endsection
