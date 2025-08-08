@extends('layouts.app')
@section('title', __('messages.events'))

@section('content')
<div class="card p-3 mb-3">
  <form class="row g-2" method="GET">
    <div class="col-md-6">
      <input class="form-control searchbar" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_events') }}">
    </div>
    <div class="col-md-3">
      <input type="date" class="form-control" name="from" value="{{ request('from') }}" />
    </div>
    <div class="col-md-3">
      <button class="btn btn-accent w-100">{{ __('messages.search') }}</button>
    </div>
  </form>
</div>

@if($events->isEmpty())
  <div class="text-muted">{{ __('messages.no_events') }}</div>
@else
  <div class="row g-3">
    @foreach($events as $e)
      <div class="col-12 col-md-6 col-lg-4">@include('components.event-card',['event'=>$e])</div>
    @endforeach
  </div>
  <div class="mt-3">{{ $events->withQueryString()->links() }}</div>
@endif
@endsection
