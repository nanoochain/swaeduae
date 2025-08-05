@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4 text-primary">{{ __('Volunteer Stories') }}</h1>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-0">
                <h5 class="text-success mb-2">"Giving back is priceless"</h5>
                <p>I volunteered for the Clean UAE campaign and made many new friends. I am proud to help my community!</p>
                <p class="mb-0 text-muted">- Mariam, Dubai</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-0">
                <h5 class="text-success mb-2">"Skills for life"</h5>
                <p>Through Sawaed UAE, I learned teamwork and leadership skills that will help me in my career.</p>
                <p class="mb-0 text-muted">- Khalid, Abu Dhabi</p>
            </div>
        </div>
    </div>
    <div class="text-center mt-5">
        <p class="text-muted">Want to share your story? <a href="{{ route('public.contact') }}">Contact us</a> and inspire others!</p>
    </div>
</div>
@endsection
