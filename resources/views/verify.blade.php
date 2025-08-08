@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h1 class="mb-3">{{ __('messages.certificate_verification') }}</h1>
    @if($certificate)
        <div class="alert alert-success">
            ✅ {{ __('messages.certificate_valid') }}
        </div>
        <ul class="list-unstyled">
            <li><strong>{{ __('messages.code') }}:</strong> {{ $certificate->code }}</li>
            <li><strong>{{ __('messages.title') }}:</strong> {{ $certificate->title }}</li>
            <li><strong>{{ __('messages.hours') }}:</strong> {{ number_format($certificate->hours, 2) }}</li>
            <li><strong>{{ __('messages.issued') }}:</strong> {{ optional($certificate->issued_at)->format('Y-m-d') ?? '-' }}</li>
        </ul>
    @else
        <div class="alert alert-danger">
            ❌ {{ __('messages.certificate_not_found') }}: {{ $code }}
        </div>
    @endif
</div>
@endsection
