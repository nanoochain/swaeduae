@extends('layouts.app')
@section('title', __('messages.site_title_full'))

@section('content')
<section class="relative overflow-hidden">
  <div class="max-w-6xl mx-auto px-4 py-16 grid md:grid-cols-2 gap-10 items-center">
    <div>
      <h1 class="text-3xl md:text-5xl font-extrabold text-brand-700">{{ __('messages.make_difference') }}</h1>
      <p class="mt-4 text-lg opacity-80">{{ __('messages.join_thousands') }}</p>
      <div class="mt-6 flex gap-3">
        <a href="{{ route('opportunities.index') }}" class="inline-flex items-center gap-2 bg-brand-600 text-white px-5 py-3 rounded-xl hover:bg-brand-700">
          {{ __('messages.explore_opportunities') }} →</a>
        <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border hover:bg-amber-100">
          {{ __('messages.events') }}</a>
      </div>
    </div>
    <img src="/images/hero-volunteer.png" alt="" class="rounded-2xl shadow-xl">
  </div>
</section>

<section class="max-w-6xl mx-auto px-4 py-10">
  <h2 class="text-xl font-semibold mb-4">{{ __('messages.upcoming_opportunities') }}</h2>
  @include('opportunities.partials.grid', ['collection' => \App\Models\Opportunity::latest('date')->take(4)->get()])
</section>

<section class="max-w-6xl mx-auto px-4 py-10">
  <h2 class="text-xl font-semibold mb-4">{{ __('messages.events') }}</h2>
  @include('events.partials.grid', ['collection' => \App\Models\Event::latest('date')->take(4)->get()])
</section>
@endsection
