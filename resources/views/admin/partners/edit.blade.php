@extends('layouts.admin_theme')

@section('content')
<h1>Edit Partner</h1>
<form method="POST" action="{{ route('admin.partners.update', $partner->id) }}">
@csrf
@method('PUT')
<label>Name</label>
<input type="text" name="name" value="{{ $partner->name }}" required />
<button type="submit">Save</button>
</form>
@endsection
