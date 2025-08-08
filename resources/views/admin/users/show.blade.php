@extends('admin.layout')

@section('content')
<h1>User Details</h1>

<p>Name: {{ $user->name ?? '' }}</p>
<p>Email: {{ $user->email ?? '' }}</p>

<a href="{{ route('admin.users.edit', $user->id ?? '') }}">Edit</a>
<a href="{{ route('admin.users.index') }}">Back to List</a>
@endsection
