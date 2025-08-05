@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4 text-primary">{{ __('messages.faq') }}</h1>
    <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq1"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">How do I register as a volunteer?</button></h2>
            <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                <div class="accordion-body">Click "Register", complete your profile, and start applying for volunteer opportunities that match your interests!</div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq2"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">Can organizations create accounts?</button></h2>
            <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">Yes! Organizations can sign up to post events and manage their own volunteers directly.</div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq3"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">How do I track my hours and certificates?</button></h2>
            <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">You can view all your volunteering history, hours, and download certificates from your dashboard after logging in.</div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq4"><button
            
                <div clas
            </div>
        </div>
    </div>
</div>
@endsection
