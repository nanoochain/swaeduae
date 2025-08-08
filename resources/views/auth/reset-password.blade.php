@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-12 p-6 bg-white rounded shadow">
    <h2 class="text-2xl mb-6 font-bold text-center">Reset Password</h2>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-4">
            <label for="email" class="block mb-1 font-semibold">Email Address</label>
            <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus
                   class="w-full border rounded px-3 py-2" />
            @error('email')<p class="text-red-600 mt-1 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block mb-1 font-semibold">New Password</label>
            <input id="password" type="password" name="password" required
                   class="w-full border rounded px-3 py-2" />
            @error('password')<p class="text-red-600 mt-1 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block mb-1 font-semibold">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   class="w-full border rounded px-3 py-2" />
        </div>

        <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-900">
            Reset Password
        </button>
    </form>
</div>
@endsection
