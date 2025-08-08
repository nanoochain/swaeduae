@extends('layouts.app')
@section('title', __('messages.certificate_verification'))

@section('content')
<div class="card p-4 text-center">
  @if(!$found)
     <h4 class="text-danger mb-2">{{ __('messages.certificate_not_found') }}</h4>
     <p class="text-muted">{{ __('messages.certificate_not_found_desc') }}</p>
  @else
     <h4 class="text-success mb-2">{{ __('messages.certificate_valid') }}</h4>
     <p class="text-muted">{{ __('messages.certificate_valid_desc') }}</p>
     <div class="mt-3">
        <div class="fw-bold">ID: {{ $certificate->id }}</div>
        <div>CODE: {{ $certificate->code }}</div>
        <div>{{ __('messages.status') }}: {{ $certificate->status }}</div>
        <div>{{ __('messages.issued_at') }}: {{ optional($certificate->issued_at)->toDateTimeString() }}</div>
     </div>
  @endif
</div>
@endsection
