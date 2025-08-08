@extends('layouts.app')
@section('title','Admin — Users')

@section('content')
<div class="table-responsive card p-3">
<table class="table align-middle">
  <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Admin</th><th></th></tr></thead>
  <tbody>
  @foreach($users as $u)
    <tr>
      <td>{{ $u->id }}</td>
      <td>{{ $u->name }}</td>
      <td>{{ $u->email }}</td>
      <td>
        @if($u->is_admin)
          <span class="badge bg-success">Yes</span>
        @else
          <span class="badge bg-secondary">No</span>
        @endif
      </td>
      <td class="text-nowrap">
        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.users.edit',$u) }}">Edit</a>
        <a class="btn btn-sm btn-outline-warning" href="{{ route('admin.users.toggle',$u->id) }}">Toggle Admin</a>
        <form class="d-inline" method="POST" action="{{ route('admin.users.destroy',$u) }}">@csrf @method('DELETE')
          <button class="btn btn-sm btn-outline-danger">Delete</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $users->links() }}
</div>
@endsection
