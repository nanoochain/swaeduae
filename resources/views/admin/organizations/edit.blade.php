@extends('layouts.admin_theme')

@section('content')
<h1>Edit Organization</h1>
<form method="POST" action="{{ route('admin.organizations.update', $organization->id) }}">
@csrf
@method('PUT')
<label>Name</label>
<input type="text" name="name" value="{{ $organization->name }}" required />
<button type="submit">Save</button>
</form>
@endsection
