@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4 text-primary">Our Partners</h1>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 text-center">
                <img src="https://www.volunteers.ae/images/partners/partner-4.png" class="mb-2" style="max-height:60px;">
                <h5>Emirates Foundation</h5>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 text-center">
                <img src="https://www.volunteers.ae/images/partners/partner-3.png" class="mb-2" style="max-height:60px;">
                <h5>Dubai Cares</h5>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 text-center">
                <img src="https://www.volunteers.ae/images/partners/partner-2.png" class="mb-2" style="max-height:60px;">
                <h5>Abu Dhabi Volunteers</h5>
            </div>
        </div>
    </div>
    <div class="text-center mt-5">
        <p class="text-muted">Are you an organization? <a href="{{ route('contact') }}">Contact us</a> to become a partner.</p>
    </div>
</div>
@endsection
