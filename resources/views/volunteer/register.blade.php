@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Volunteer Registration</h2>
    <form method="POST" action="{{ route('volunteer.register') }}">
        @csrf
        <input type="text" name="name" placeholder="Your name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" class="btn btn-success">Register</button>
    </form>
</div>
@endsection
