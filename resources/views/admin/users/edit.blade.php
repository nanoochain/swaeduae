@extends('layouts.app')
@section('title','Admin — Edit User')

@section('content')
<form method="POST" action="{{ route('admin.users.update',$user) }}" class="card p-4">
  @csrf @method('PUT')
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Name</label>
      <input class="form-control" name="name" value="{{ old('name',$user->name) }}" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Email</label>
      <input type="email" class="form-control" name="email" value="{{ old('email',$user->email) }}" required>
    </div>
    <div class="col-12 form-check">
      <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin" value="1" {{ $user->is_admin ? 'checked' : '' }}>
      <label class="form-check-label" for="is_admin">Administrator</label>
    </div>
    <div class="col-12">
      <button class="btn btn-dark">Save</button>
    </div>
  </div>
</form>
@endsection
