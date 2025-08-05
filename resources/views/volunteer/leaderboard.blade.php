@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-2xl font-bold mb-4">🏆 قائمة المتصدرين</h1>
    <table class="table-auto w-full">
        <thead><tr><th>الاسم</th><th>الساعات</th></tr></thead>
        <tbody>
            @forelse($leaders ?? [] as $user)
                <tr><td>{{ $user->name }}</td><td>{{ $user->hours }}</td></tr>
            @empty
                <tr><td colspan="2">لا يوجد بيانات.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
