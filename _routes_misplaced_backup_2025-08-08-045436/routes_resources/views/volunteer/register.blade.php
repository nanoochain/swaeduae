@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-8 rounded shadow">

    <h1 class="text-2xl font-bold mb-6">Volunteer Registration</h1>

    <form method="POST" action="{{ route('volunteer.register.submit') }}">
        @csrf

        <div class="mb-4">
            <label class="block mb-1" for="name">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required
                   class="w-full border px-3 py-2 rounded @error('name') border-red-500 @enderror" />
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1" for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                   class="w-full border px-3 py-2 rounded @error('email') border-red-500 @enderror" />
            @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1" for="password">Password</label>
            <input id="password" name="password" type="password" required
                   class="w-full border px-3 py-2 rounded @error('password') border-red-500 @enderror" />
            @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block mb-1" for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                   class="w-full border px-3 py-2 rounded" />
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded hover:bg-indigo-700 font-semibold">
            Register
        </button>
    </form>
</div>
@endsection
