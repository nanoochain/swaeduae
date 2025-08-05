@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4 text-primary">{{ __('messages.contact') }}</h1>
    <div class="row">
        <div class="col-md-7">
            <form method="POST" action="#">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Your Name</label>
                    <input type="text" class="form-control" name="name" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea class="form-control" name="message" rows="4" required></textarea>
                </div>
                <button class="btn btn-primary px-5">Send</button>
            </form>
        </div>
        <div class="col-md-5 mt-4 mt-md-0">
            <div class="bg-light rounded shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-3">Sawaed UAE</h5>
                <p class="mb-2"><i class="bi bi-envelope me-2"></i> info@swaeduae.ae</p>
                <p class="mb-2"><i class="bi bi-telephone me-2"></i> +971 50 123 4567</p>
                <p class="mb-2"><i class="bi bi-geo-alt me-2"></i> Dubai, United Arab Emirates</p>
                <hr>
                <p class="small text-muted">We love to hear from you! Fill out the form and our team will respond as soon as possible.</p>
            </div>
        </div>
    </div>
</div>
@endsection
