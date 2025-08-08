@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-12">
    <h1 class="text-3xl font-bold mb-4">{{ __('messages.contact_title') ?? 'Contact Us' }}</h1>
    <p class="mb-6">{{ __('messages.contact_subtitle') ?? 'For any questions or support, contact us below.' }}</p>
    <form method="POST" action="#">
        @csrf
        <div class="mb-4">
            <label class="block mb-2">{{ __('messages.name') ?? 'Name' }}</label>
            <input type="text" class="form-input w-full" name="name" required>
        </div>
        <div class="mb-4">
            <label class="block mb-2">{{ __('messages.email') ?? 'Email' }}</label>
            <input type="email" class="form-input w-full" name="email" required>
        </div>
        <div class="mb-4">
            <label class="block mb-2">{{ __('messages.message') ?? 'Message' }}</label>
            <textarea class="form-input w-full" name="message" rows="4" required></textarea>
        </div>
        <button class="bg-green-700 text-white px-6 py-2 rounded" type="submit">
            {{ __('messages.send') ?? 'Send' }}
        </button>
    </form>
</div>
@endsection
