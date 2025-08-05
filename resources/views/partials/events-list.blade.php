@if(isset($events) && $events->count())
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($events as $event)
      <div class="bg-white shadow rounded p-4 flex flex-col">
        <div class="font-bold text-lg mb-1">{{ $event->title }}</div>
        <div class="mb-2 text-gray-700">{{ $event->description }}</div>
        <div class="mb-2 text-sm text-gray-500">{{ __('Date:') }} {{ $event->date->format('d/m/Y') }}</div>
        <a href="{{ route('events.show', $event) }}" class="btn-primary mt-auto text-center">{{ __('View Details') }}</a>
      </div>
    @endforeach
  </div>
@else
  <div class="text-center text-gray-400">{{ __('No events found.') }}</div>
@endif
