@extends('layouts.app')

@section('content')
<h1>My Profile</h1>
<p>Name: {{ $user->name ?? '' }}</p>
<p>Email: {{ $user->email ?? '' }}</p>

<a href="{{ route('volunteer.profile.edit') }}">Edit Profile</a>
@endsection
