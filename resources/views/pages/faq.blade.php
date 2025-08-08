@extends('layouts.app')
@section('title', __('messages.faq'))
@section('content')
<div class="card p-4">
  <h3 class="mb-3">{{ __('messages.faq') }}</h3>
  <p class="text-muted">{{ __('messages.faq_text') }}</p>
</div>
@endsection
