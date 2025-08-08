@extends('layouts.app')
@section('title','Admin — Events')

@section('content')
<a class="btn btn-dark mb-3" href="{{ route('admin.events.create') }}">+ New Event</a>
<div class="table-responsive">
<table class="table">
  <thead><tr><th>ID</th><th>Title</th><th>Date</th><th>Location</th><th></th></tr></thead>
  <tbody>
    @foreach($events as $e)
      <tr>
        <td>{{ $e->id }}</td>
        <td>{{ $e->title }}</td>
        <td>{{ $e->date->toDateString() }}</td>
        <td>{{ $e->location }}</td>
        <td class="text-nowrap">
          <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.events.edit',$e) }}">Edit</a>
          <form class="d-inline" method="POST" action="{{ route('admin.events.destroy',$e) }}">@csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger">Delete</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
</div>
{{ $events->links() }}
@endsection
