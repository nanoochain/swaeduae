@extends('guest')
@section('content')
    <h1>Contact Us</h1>
    <form class="mt-4" method="POST" action="#">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label>Message</label>
            <textarea class="form-control" name="message" rows="4" required></textarea>
        </div>
        <button class="btn-primary">Send</button>
    </form>
@endsection
