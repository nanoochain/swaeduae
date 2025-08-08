@extends('layouts.app')
@section('title', __('messages.contact'))
@section('content')
<div class="card p-4">
  <h3 class="mb-3">{{ __('messages.contact') }}</h3>
  <p class="text-muted">{{ __('messages.contact_text') }}</p>
  <ul class="mb-0">
    <li>Email: info@swaeduae.ae</li>
  </ul>
</div>
@endsection
