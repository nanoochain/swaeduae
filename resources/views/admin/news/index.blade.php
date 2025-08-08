@extends('layouts.admin_theme')

@section('content')
<h1>News</h1>
<a href="{{ route('admin.news.create') }}">Add News</a>
<table>
<thead><tr><th>ID</th><th>Title</th><th>Actions</th></tr></thead>
<tbody>
@foreach($news as $newsItem)
<tr>
<td>{{ $newsItem->id }}</td>
<td>{{ $newsItem->title }}</td>
<td>
<a href="{{ route('admin.news.edit', $newsItem->id) }}">Edit</a> |
<form method="POST" action="{{ route('admin.news.destroy', $newsItem->id) }}" style="display:inline">
@csrf
@method('DELETE')
<button type="submit" onclick="return confirm('Delete this news?')">Delete</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $news->links() }}
@endsection
