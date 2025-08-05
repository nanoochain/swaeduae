@extends('layouts.app')

@section('content')
<h2>Team: {{ $team->name }}</h2>
<p>{{ $team->description }}</p>
<p>Owner: {{ $team->owner->name }}</p>

<h3>Members</h3>
<ul>
@foreach($members as $member)
    <li>{{ $member->name }} ({{ $member->email }})</li>
@endforeach
</ul>

<h4>Invite Member</h4>
@if(session('success'))
    <div class="bg-green-200 p-3 rounded mb-4">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="bg-red-200 p-3 rounded mb-4">{{ session('error') }}</div>
@endif

<form action="{{ route('teams.invite', $team) }}" method="POST">
    @csrf
    <input type="email" name="email" placeholder="User email" required class="border p-2 w-full mb-2" />
    <button type="submit" class="bg-primary text-white px-4 py-2 rounded">Invite</button>
</form>
@endsection
