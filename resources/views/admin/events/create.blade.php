@extends('layouts.app')
@section('title','Admin — Create Event')

@section('content')
<form method="POST" action="{{ route('admin.events.store') }}" class="card p-4">
  @csrf
  @include('admin.events.form', ['button' => 'Create'])
</form>
@endsection
