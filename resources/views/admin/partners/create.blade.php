@extends('layouts.admin_theme')

@section('content')
<h1>Add Partner</h1>
<form method="POST" action="{{ route('admin.partners.store') }}">
@csrf
<label>Name</label>
<input type="text" name="name" required />
<button type="submit">Create</button>
</form>
@endsection
