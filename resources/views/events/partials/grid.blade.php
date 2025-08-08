@php use Illuminate\Support\Str; @endphp
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
@forelse($collection as $e)
  <a href="{{ route('events.show',$e) }}" class="group bg-white rounded-xl border hover:shadow-md transition overflow-hidden">
    @if($e->poster_path)
      <img src="{{ asset('storage/'.$e->poster_path) }}" class="w-full h-40 object-cover">
    @endif
    <div class="p-4 space-y-2">
      <h3 class="font-semibold group-hover:text-brand-700">{{ $e->title }}</h3>
      <p class="text-sm opacity-70">{{ Str::limit($e->summary, 100) }}</p>
      <div class="text-xs opacity-70 flex gap-3">
        @if($e->region) <span>📍 {{ $e->region }}</span> @endif
        @if($e->date) <span>📅 {{ $e->date->format('Y-m-d') }}</span> @endif
      </div>
    </div>
  </a>
@empty
  <p class="opacity-60">{{ __('messages.no_events') }}</p>
@endforelse
</div>
