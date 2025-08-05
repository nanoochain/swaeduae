@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-8 text-blue-800">
            @if(Auth::check())
                Welcome, {{ Auth::user()->name }}!
            @else
                Welcome, Guest!
            @endif
        </h1>
        <!-- Rest of your dashboard content -->
    </div>
@endsection
