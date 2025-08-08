@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
  <a href="{{ route('opportunities.index') }}" class="text-brand hover:underline">&larr; {{ __('messages.back') }}</a>

  <div class="bg-white rounded-2xl border shadow-card mt-3 overflow-hidden">
    @if($opportunity->poster_path)
      <img src="{{ asset('storage/'.$opportunity->poster_path) }}" class="w-full max-h-[360px] object-cover">
    @endif
    <div class="p-6 space-y-4">
      <h1 class="text-2xl font-bold">{{ $opportunity->title }}</h1>
      @if($opportunity->summary)<p class="opacity-80">{{ $opportunity->summary }}</p>@endif

      <div class="grid sm:grid-cols-2 gap-3 text-sm">
        @if($opportunity->region)<div>📍 <strong>{{ __('messages.region') }}:</strong> {{ $opportunity->region }}</div>@endif
        @if($opportunity->location)<div>🏢 <strong>{{ __('messages.location') }}:</strong> {{ $opportunity->location }}</div>@endif
        @if($opportunity->date)<div>📅 <strong>{{ __('messages.date') }}:</strong> {{ $opportunity->date->format('Y-m-d') }}</div>@endif
        <div>👥 <strong>{{ __('messages.slots') }}:</strong> {{ $opportunity->slots }}</div>
        <div>🔖 <strong>{{ __('messages.status') }}:</strong> {{ $opportunity->status }}</div>
      </div>

      @if($opportunity->requirements)
        <div class="pt-3">
          <h3 class="font-semibold mb-1">{{ __('messages.requirements') }}</h3>
          <p class="opacity-80">{{ $opportunity->requirements }}</p>
        </div>
      @endif

      <div class="pt-4">
        <button class="bg-emirates-red text-white px-4 py-2 rounded-lg hover:opacity-90">Register</button>
      </div>
    </div>
  </div>
</div>
@endsection
