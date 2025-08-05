@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-w-md mx-auto mt-20 p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Register</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label class="block mb-2 font-semibold" for="name">Name</label>
        <input id="name" type="text" name="name" required autofocus class="w-full border rounded px-3 py-2 mb-4" value="{{ old('name') }}" />
        @error('name')<p class="text-red-600 mb-2">{{ $message }}</p>@enderror

        <label class="block mb-2 font-semibold" for="email">Email</label>
        <input id="email" type="email" name="email" required class="w-full border rounded px-3 py-2 mb-4" value="{{ old('email') }}" />
        @error('email')<p class="text-red-600 mb-2">{{ $message }}</p>@enderror

        <label class="block mb-2 font-semibold" for="password">Password</label>
        <input id="password" type="password" name="password" required class="w-full border rounded px-3 py-2 mb-4" />
        @error('password')<p class="text-red-600 mb-2">{{ $message }}</p>@enderror

        <label class="block mb-2 font-semibold" for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full border rounded px-3 py-2 mb-4" />

        <button type="submit" class="w-full bg-blue-700 text-white font-bold py-2 rounded hover:bg-blue-800">Register</button>
    </form>
</div>
@endsection
