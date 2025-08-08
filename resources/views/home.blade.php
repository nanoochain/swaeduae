@extends('layouts.app')
@section('title','سواعد الإمارات')

@section('content')
<section class="hero mb-5">
  <div class="row align-items-center g-4">
    <div class="col-lg-7">
      <h1 class="display-5">{{ __('messages.make_difference') }}</h1>
      <p class="lead mb-4">{{ __('messages.join_thousands') }}</p>
      <a href="{{ route('events.index') }}" class="btn btn-accent btn-lg">{{ __('messages.browse_events') }}</a>
    </div>
    <div class="col-lg-5">
      <div class="card p-3">
        <form action="{{ route('events.index') }}" method="GET">
          <input name="search" class="form-control searchbar" placeholder="{{ __('messages.search_events') }}">
          <div class="small text-muted mt-2">
            Tip: press <span class="kbd">Enter</span> to search
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<section class="mb-5">
  <h3 class="section-title">{{ __('messages.upcoming_opportunities') }}</h3>
  @if($upcoming->isEmpty())
    <div class="text-muted">{{ __('messages.no_opportunities') }}</div>
  @else
    <div class="row g-3">
      @foreach($upcoming as $e)
        <div class="col-12 col-md-6 col-lg-4">@include('components.event-card',['event'=>$e])</div>
      @endforeach
    </div>
  @endif
</section>

<section>
  <h3 class="section-title">{{ __('messages.latest_events') }}</h3>
  <div class="row g-3">
    @foreach($latest as $e)
      <div class="col-12 col-md-6 col-lg-4">@include('components.event-card',['event'=>$e])</div>
    @endforeach
  </div>
</section>
@endsection
