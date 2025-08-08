@extends('layouts.app')

@section('content')
  <h1 class="mb-3">{{ __('My Volunteer Hours') }}</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <form method="POST" action="{{ route('volunteer.hours.store') }}" class="mb-4" style="border:1px solid #eaeaea; padding:12px;">
    @csrf
    <div class="mb-2">
      <label for="event_id">{{ __('Event') }}</label>
      <select id="event_id" name="event_id" required class="form-control">
        <option value="">{{ __('Choose...') }}</option>
        @foreach($events as $e)
          <option value="{{ $e->id }}">{{ $e->title }}</option>
        @endforeach
      </select>
      @error('event_id') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-2">
      <label for="hours">{{ __('Hours') }}</label>
      <input type="number" min="0.5" step="0.5" max="24" id="hours" name="hours" required class="form-control" />
      @error('hours') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-primary">{{ __('Submit Hours') }}</button>
  </form>

  <h2 class="mt-4">{{ __('Submitted Hours') }}</h2>
  <table class="table table-striped w-100">
    <thead>
      <tr>
        <th>{{ __('ID') }}</th>
        <th>{{ __('Event') }}</th>
        <th>{{ __('Hours') }}</th>
        <th>{{ __('Status') }}</th>
        <th>{{ __('Date') }}</th>
      </tr>
    </thead>
    <tbody>
      @forelse($hours as $h)
        <tr>
          <td>{{ $h->id }}</td>
          <td>{{ optional(\Illuminate\Support\Facades\DB::table('events')->find($h->event_id))->title }}</td>
          <td>{{ $h->hours }}</td>
          <td>{{ $h->approved ? __('Approved') : __('Pending') }}</td>
          <td>{{ $h->created_at }}</td>
        </tr>
      @empty
        <tr><td colspan="5">{{ __('No hours yet.') }}</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection
