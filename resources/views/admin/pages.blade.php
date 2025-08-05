@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Edit Pages</h2>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    <ul class="nav nav-tabs mb-4" role="tablist">
        @foreach($pages as $i => $page)
        <li class="nav-item" role="presentation">
            <a class="nav-link @if($i==0) active @endif" data-bs-toggle="tab" href="#tab-{{ $page }}" role="tab">{{ ucfirst($page) }}</a>
        </li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach($pages as $i => $page)
        <div class="tab-pane fade @if($i==0) show active @endif" id="tab-{{ $page }}" role="tabpanel">
            <form method="POST" action="{{ route('admin.pages.update', $page) }}">
                @csrf
                <textarea name="content" class="form-control" rows="12">{{ $contents[$page] }}</textarea>
                <button class="btn btn-success mt-2">Save {{ ucfirst($page) }}</button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection
