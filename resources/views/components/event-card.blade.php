@props(['event'])
<div class="card card-event h-100 p-3">
  <a class="title d-block mb-1" href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
  <div class="meta mb-2">
    {{ $event->location }} — {{ optional($event->date)->toDateString() }}
  </div>
  <p class="text-muted small mb-3">{{ \Illuminate\Support\Str::limit($event->description, 120) }}</p>
  <div>
    <a class="btn btn-sm btn-accent" href="{{ route('events.show',$event) }}">{{ __('messages.view') }}</a>
  </div>
</div>
