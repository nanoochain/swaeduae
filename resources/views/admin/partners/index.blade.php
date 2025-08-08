@extends('layouts.admin_theme')

@section('content')
<h1>Partners</h1>
<a href="{{ route('admin.partners.create') }}">Add Partner</a>
<table>
<thead><tr><th>ID</th><th>Name</th><th>Actions</th></tr></thead>
<tbody>
@foreach($partners as $partner)
<tr>
<td>{{ $partner->id }}</td>
<td>{{ $partner->name }}</td>
<td>
<a href="{{ route('admin.partners.edit', $partner->id) }}">Edit</a> |
<form method="POST" action="{{ route('admin.partners.destroy', $partner->id) }}" style="display:inline">
@csrf
@method('DELETE')
<button type="submit" onclick="return confirm('Delete this partner?')">Delete</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $partners->links() }}
@endsection
