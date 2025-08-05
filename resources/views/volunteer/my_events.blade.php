@extends('layouts.guest')

@section('content')
<div class="container py-4">
    <h1 class="text-2xl font-bold mb-4">📅 فعالياتي</h1>
    @forelse($myEvents ?? [] as $event)
        <div class="border p-4 mb-3">
            <h2 class="text-xl font-bold">{{ $event->title }}</h2>
            <p>{{ $event->description }}</p>
        </div>
    @empty
        <p>لا توجد فعاليات مسجلة.</p>
    @endforelse
</div>
@endsection
