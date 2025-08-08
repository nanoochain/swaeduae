@extends('layouts.app')
@section('content')
<div class="container my-4">
  <h1 class="h4 mb-3">Edit Opportunity</h1>
  @if($errors->any()) <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
  <form method="POST" action="{{ route('admin.opportunities.update', $item) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.opportunities._form', ['item'=>$item])
  </form>
</div>
@endsection
