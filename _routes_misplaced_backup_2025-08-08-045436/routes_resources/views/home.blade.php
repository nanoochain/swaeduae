@extends('layouts.app')

@section('content')
<div style="background-color: #fdf5e6; min-height: 100vh;" class="flex flex-col min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow py-4 px-6">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
      <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-800">Swaed UAE</a>
      <nav class="flex space-x-6 text-indigo-800 font-semibold">
        <a href="{{ route('home') }}" class="hover:underline">Home</a>
        <a href="{{ route('opportunities.index') }}" class="hover:underline">Opportunities</a>
        <a href="{{ route('events.index') }}" class="hover:underline">Events</a>
        <a href="{{ route('about') }}" class="hover:underline">About</a>
        <a href="{{ route('faq') }}" class="hover:underline">FAQ</a>
        <a href="{{ route('contact') }}" class="hover:underline">Contact</a>
      </nav>
    </div>
  </header>

  <!-- Main content -->
  <main class="flex-grow max-w-7xl mx-auto px-6 py-10">

    <!-- Hero -->
    <section class="text-center mb-12">
      <h1 class="text-5xl font-extrabold mb-4 text-indigo-900">Welcome to Swaed UAE</h1>
      <p class="text-lg max-w-xl mx-auto mb-8 text-indigo-700">
        Connecting volunteers with the best opportunities and events across the UAE.
      </p>

      <!-- Search form -->
      <form action="{{ route('opportunities.index') }}" method="GET" class="max-w-xl mx-auto flex rounded overflow-hidden shadow">
        <input 
          type="search" 
          name="q" 
          placeholder="Search for opportunities or events..." 
          class="flex-grow px-4 py-3 border border-r-0 border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        />
        <button type="submit" class="bg-indigo-600 text-white px-6 hover:bg-indigo-700">
          Search
        </button>
      </form>
    </section>

    <!-- Stats -->
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-10 text-center mt-16 text-indigo-900">
      <div class="bg-white p-6 rounded shadow">
        <p class="text-4xl font-bold">1,200+</p>
        <p class="mt-2 text-lg">Registered Volunteers</p>
      </div>
      <div class="bg-white p-6 rounded shadow">
        <p class="text-4xl font-bold">45</p>
        <p class="mt-2 text-lg">Organizations</p>
      </div>
      <div class="bg-white p-6 rounded shadow">
        <p class="text-4xl font-bold">8,100</p>
        <p class="mt-2 text-lg">Volunteer Hours</p>
      </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-indigo-100 rounded-lg p-10 text-center shadow mt-16 max-w-3xl mx-auto">
      <h2 class="text-3xl font-semibold mb-4">Become a Volunteer Today!</h2>
      <p class="mb-6 text-indigo-900 max-w-xl mx-auto">
        Join thousands of volunteers making a difference across the UAE.
      </p>
      <a href="{{ route('volunteer.register') }}" class="inline-block bg-indigo-600 text-white px-8 py-3 rounded hover:bg-indigo-700">
        Get Started
      </a>
    </section>

  </main>

  <!-- Footer -->
  <footer class="bg-indigo-50 text-indigo-700 py-6 text-center mt-20">
    <div class="space-x-4">
      <a href="{{ route('about') }}" class="hover:underline">About</a>
      <a href="{{ route('faq') }}" class="hover:underline">FAQ</a>
      <a href="{{ route('contact') }}" class="hover:underline">Contact</a>
    </div>
    <p class="mt-3 text-sm">SwaedUAE © 2025 — Made with ❤️ in UAE</p>
  </footer>

</div>
@endsection
