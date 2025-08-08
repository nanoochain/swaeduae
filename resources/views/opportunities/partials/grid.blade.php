@php use Illuminate\Support\Str; @endphp
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
@forelse($collection as $o)
  <a href="{{ route('opportunities.show',$o) }}" class="group bg-white rounded-xl border hover:shadow-md transition overflow-hidden">
    @if($o->poster_path)
      <img src="{{ asset('storage/'.$o->poster_path) }}" class="w-full h-40 object-cover">
    @endif
    <div class="p-4 space-y-2">
      <h3 class="font-semibold group-hover:text-brand-700">{{ $o->title }}</h3>
      <p class="text-sm opacity-70">{{ Str::limit($o->summary, 100) }}</p>
      <div class="text-xs opacity-70 flex gap-3">
        @if($o->region) <span>📍 {{ $o->region }}</span> @endif
        @if($o->date) <span>📅 {{ $o->date->format('Y-m-d') }}</span> @endif
      </div>
    </div>
  </a>
@empty
  <p class="opacity-60">{{ __('messages.no_opportunities') }}</p>
@endforelse
</div>
