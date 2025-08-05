@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto mt-20 p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Login</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label class="block mb-2 font-semibold" for="email">Email</label>
        <input id="email" type="email" name="email" required autofocus class="w-full border rounded px-3 py-2 mb-4" value="{{ old('email') }}" />
        @error('email')<p class="text-red-600 mb-2">{{ $message }}</p>@enderror

        <label class="block mb-2 font-semibold" for="password">Password</label>
        <input id="password" type="password" name="password" required class="w-full border rounded px-3 py-2 mb-4" />
        @error('password')<p class="text-red-600 mb-2">{{ $message }}</p>@enderror

        <div class="mb-4 flex items-center">
            <input id="remember" type="checkbox" name="remember" class="mr-2" />
            <label for="remember" class="select-none">Remember Me</label>
        </div>

        <button type="submit" class="w-full bg-blue-700 text-white font-bold py-2 rounded hover:bg-blue-800">Login</button>
    </form>
</div>
@endsection
