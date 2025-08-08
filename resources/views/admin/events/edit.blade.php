@extends('layouts.app')
@section('title','Admin — Edit Event')

@section('content')
<form method="POST" action="{{ route('admin.events.update',$event) }}" class="card p-4">
  @csrf @method('PUT')
  @include('admin.events.form', ['button' => 'Update'])
</form>
@endsection
