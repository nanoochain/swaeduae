@extends('layouts.app')
@section('title', __('messages.dashboard'))

@section('content')
<div class="row g-3">
  <div class="col-lg-4">
    <div class="card p-3">
      <h5 class="mb-2">{{ auth()->user()->name }}</h5>
      <div class="text-muted small mb-2">{{ auth()->user()->email }}</div>
      <div class="fw-bold">{{ __('messages.total_hours') }}: {{ $total_hours }}</div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="card p-3 mb-3">
      <h6 class="mb-3">{{ __('messages.recent_hours') }}</h6>
      @if($hours->isEmpty())
        <div class="text-muted small">{{ __('messages.no_hours') }}</div>
      @else
        <div class="table-responsive">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>{{ __('messages.date') }}</th>
                <th>{{ __('messages.hours') }}</th>
                <th>{{ __('messages.status') }}</th>
                <th>{{ __('messages.notes') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($hours as $h)
                <tr>
                  <td>{{ $h->date->toDateString() }}</td>
                  <td>{{ $h->hours }}</td>
                  <td>{{ $h->status }}</td>
                  <td>{{ $h->notes }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>

    <div class="card p-3">
      <h6 class="mb-3">{{ __('messages.certificates') }}</h6>
      @if($certificates->isEmpty())
        <div class="text-muted small">{{ __('messages.no_certificates') }}</div>
      @else
        <ul class="list-group">
          @foreach($certificates as $c)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>#{{ $c->id }} — {{ $c->status }} — {{ optional($c->issued_at)->toDateString() }}</span>
              <a class="btn btn-outline-secondary btn-sm" href="{{ route('cert.verify', $c->code) }}">{{ __('messages.view') }}</a>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
</div>
@endsection

<div class="card p-3 mt-3">
  <h6 class="mb-3">{{ __('messages.my_events') ?? 'My Events' }}</h6>
  @php
    $myEvents = \Illuminate\Support\Facades\DB::table('event_user')
      ->join('events','events.id','=','event_user.event_id')
      ->where('event_user.user_id', auth()->id())
      ->orderBy('events.date')
      ->select('events.*','event_user.joined_at')
      ->get();
  @endphp
  @if($myEvents->isEmpty())
    <div class="text-muted small">{{ __('messages.no_events') }}</div>
  @else
    <div class="table-responsive">
      <table class="table table-sm">
        <thead><tr>
          <th>{{ __('messages.date') }}</th>
          <th>{{ __('messages.events') }}</th>
          <th>{{ __('messages.hours') }}</th>
          <th></th>
        </tr></thead>
        <tbody>
          @foreach($myEvents as $e)
            <tr>
              <td>{{ optional(\Carbon\Carbon::parse($e->date))->toDateString() }}</td>
              <td><a href="{{ route('events.show',$e->id) }}">{{ $e->title }}</a></td>
              <td>{{ $e->hours }}</td>
              <td>
                <form method="POST" action="{{ route('events.unjoin',$e->id) }}">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">{{ __('messages.leave_event') ?? 'Leave' }}</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>

<div class="card p-3 mt-3">
  <h6 class="mb-3">{{ __('messages.my_events') ?? 'My Events' }}</h6>
  @php
    $myEvents = \Illuminate\Support\Facades\DB::table('event_user')
      ->join('events','events.id','=','event_user.event_id')
      ->where('event_user.user_id', auth()->id())
      ->orderBy('events.date')
      ->select('events.*','event_user.joined_at')
      ->get();
  @endphp
  @if($myEvents->isEmpty())
    <div class="text-muted small">{{ __('messages.no_events') }}</div>
  @else
    <div class="table-responsive">
      <table class="table table-sm">
        <thead><tr>
          <th>{{ __('messages.date') }}</th>
          <th>{{ __('messages.events') }}</th>
          <th>{{ __('messages.hours') }}</th>
          <th></th>
        </tr></thead>
        <tbody>
          @foreach($myEvents as $e)
            <tr>
              <td>{{ optional(\Carbon\Carbon::parse($e->date))->toDateString() }}</td>
              <td><a href="{{ route('events.show',$e->id) }}">{{ $e->title }}</a></td>
              <td>{{ $e->hours }}</td>
              <td>
                <form method="POST" action="{{ route('events.unjoin',$e->id) }}">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">{{ __('messages.leave_event') ?? 'Leave' }}</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
