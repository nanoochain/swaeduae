@extends('layouts.admin_theme')

@section('content')
<h1>Edit News</h1>
<form method="POST" action="{{ route('admin.news.update', $newsItem->id) }}">
@csrf
@method('PUT')
<label>Title</label>
<input type="text" name="title" value="{{ $newsItem->title }}" required />
<label>Content</label>
<textarea name="content" required>{{ $newsItem->content }}</textarea>
<button type="submit">Save</button>
</form>
@endsection
