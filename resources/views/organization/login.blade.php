@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Organization Login</h2>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <form method="POST" action="{{ route('organization.login') }}">
        @csrf
        <div><label>Email:</label><input type="email" name="email"></div>
        <div><label>Password:</label><input type="password" name="password"></div>
        <button type="submit">Login</button>
    </form>
</div>
@endsection
