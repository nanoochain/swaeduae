@extends('layouts.app')
@section('title', $event->title)

@section('content')
<div class="card p-4">
  <span class="badge bg-light text-dark mb-2">{{ $event->location }}</span>
  <h2 class="mb-2">{{ $event->title }}</h2>
  <div class="text-muted mb-3">{{ optional($event->date)->toDateString() }}</div>
  <div class="mb-4">{!! nl2br(e($event->description)) !!}</div>

  @auth
    @php
      $isJoined = \Illuminate\Support\Facades\DB::table('event_user')
        ->where('event_id', $event->id)->where('user_id', auth()->id())->exists();
    @endphp
    @if(!$isJoined)
      <form method="POST" action="{{ route('events.join', $event) }}">@csrf
        <button class="btn btn-accent">{{ __('messages.join_event') }}</button>
      </form>
    @else
      <form method="POST" action="{{ route('events.unjoin', $event) }}" class="d-inline">@csrf @method('DELETE')
        <button class="btn btn-outline-danger">{{ __('messages.leave_event') }}</button>
      </form>
      <a class="btn btn-outline-secondary" href="{{ route('volunteer.profile') }}">{{ __('messages.dashboard') }}</a>
    @endif
  @else
    <a href="{{ route('login') }}" class="btn btn-accent">{{ __('messages.login_to_join') }}</a>
  @endauth
</div>
@endsection
