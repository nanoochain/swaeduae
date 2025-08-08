@extends('layouts.admin_theme')

@section('content')
<h1>Organizations</h1>
<table>
<thead><tr><th>ID</th><th>Name</th><th>Actions</th></tr></thead>
<tbody>
@foreach($organizations as $organization)
<tr>
<td>{{ $organization->id }}</td>
<td>{{ $organization->name }}</td>
<td>
<a href="{{ route('admin.organizations.edit', $organization->id) }}">Edit</a>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $organizations->links() }}
@endsection
