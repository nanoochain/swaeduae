@extends('layouts.app')
@section('title', __('messages.opportunities'))

@section('content')
@php use Illuminate\Support\Str; @endphp
<div class="max-w-6xl mx-auto px-4 py-6">
  <h1 class="text-2xl font-bold mb-3">{{ __('messages.opportunities') }}</h1>

  <form method="GET" class="sticky top-20 z-40 bg-white border rounded-xl p-3 shadow-card">
    <div class="grid md:grid-cols-6 gap-2">
      <input name="q" value="{{ request('q') }}" placeholder="{{ __('Search') }}"
             class="md:col-span-2 border rounded-lg px-3 py-2">
      <select name="region" class="border rounded-lg px-3 py-2">
        <option value="">{{ __('All Regions') }}</option>
        @foreach($regions as $r)
          <option value="{{ $r }}" @selected(request('region')===$r)>{{ $r }}</option>
        @endforeach
      </select>
      <select name="category" class="border rounded-lg px-3 py-2">
        <option value="">{{ __('Category') }}</option>
        @foreach($categories as $c)
          <option value="{{ $c }}" @selected(request('category')===$c)>{{ $c }}</option>
        @endforeach
      </select>
      <input type="date" name="from" value="{{ request('from') }}" class="border rounded-lg px-3 py-2">
      <input type="date" name="to" value="{{ request('to') }}" class="border rounded-lg px-3 py-2">
      <select name="status" class="border rounded-lg px-3 py-2">
        <option value="">{{ __('Status') }}</option>
        @foreach(['open','closed','archived'] as $s)
          <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>
        @endforeach
      </select>
    </div>
    <div class="mt-3 flex gap-2">
      <button class="bg-brand text-white px-4 py-2 rounded-lg">{{ __('Search') }}</button>
      <a href="{{ route('opportunities.index') }}" class="px-4 py-2 rounded-lg border">{{ __('Reset') }}</a>
    </div>
  </form>

  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-5">
    @forelse($opportunities as $o)
      <a href="{{ route('opportunities.show',$o) }}" class="group bg-white rounded-xl border hover:shadow-card transition overflow-hidden">
        @if($o->poster_path)
          <img src="{{ asset('storage/'.$o->poster_path) }}" class="w-full h-40 object-cover">
        @endif
        <div class="p-4 space-y-2">
          <h3 class="font-semibold group-hover:text-brand">{{ $o->title }}</h3>
          <p class="text-sm opacity-70">{{ Str::limit($o->summary, 120) }}</p>
          <div class="text-xs opacity-70 flex gap-3">
            @if($o->region) <span>📍 {{ $o->region }}</span> @endif
            @if($o->date) <span>📅 {{ $o->date->format('Y-m-d') }}</span> @endif
            @if($o->category) <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border">{{ $o->category }}</span>@endif
          </div>
        </div>
      </a>
    @empty
      <p class="opacity-60">{{ __('messages.no_opportunities') }}</p>
    @endforelse
  </div>

  <div class="mt-6">{{ $opportunities->links() }}</div>
</div>
@endsection
