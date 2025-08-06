@extends('layouts.app')
@section('title', __('Volunteer Dashboard'))

@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-8 max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold text-blue-900 mb-6">
            {{ __('Welcome, ') }}{{ $user->name ?? '' }}!
        </h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="dashboard-card bg-blue-50 p-6 rounded text-center shadow">
                <i class="bi bi-person-circle text-blue-700 text-3xl"></i>
                <div class="text-lg mt-2">{{ __('My Certificates') }}</div>
                <div class="text-2xl font-bold">{{ $certCount ?? ($certificates->count() ?? 0) }}</div>
            </div>
            <div class="dashboard-card bg-green-50 p-6 rounded text-center shadow">
                <i class="bi bi-clock text-green-700 text-3xl"></i>
                <div class="text-lg mt-2">{{ __('Total Volunteer Hours') }}</div>
                <div class="text-2xl font-bold">{{ $hours ?? 0 }}</div>
            </div>
            <div class="dashboard-card bg-yellow-50 p-6 rounded text-center shadow">
                <i class="bi bi-calendar-event text-yellow-700 text-3xl"></i>
                <div class="text-lg mt-2">{{ __('Upcoming Events') }}</div>
                <div class="text-2xl font-bold">{{ $upcoming ?? ($events->count() ?? 0) }}</div>
            </div>
        </div>

        <div class="row g-4 mt-4">
            <div class="col-lg-8">
                <div class="dashboard-card bg-white p-6 rounded shadow mb-8">
                    <h2 class="text-xl font-bold mb-4">{{ __('My Participation Over Time') }}</h2>
                    <canvas id="volChart" height="120"></canvas>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dashboard-card bg-white p-6 rounded shadow mb-8">
                    <h2 class="text-xl font-bold mb-2">{{ __('Badges & Achievements') }}</h2>
                    <ul class="list-disc ml-5" style="max-height: 160px; overflow:auto;">
                        @foreach($badges ?? [] as $badge)
                            <li class="mb-2 text-green-700"><i class="bi bi-patch-check-fill text-success"></i> {{ $badge }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
            <div>
                <h2 class="font-bold text-lg mb-2">{{ __('Your Registered Events') }}</h2>
                <ul>
                @foreach($events ?? [] as $event)
                    <li>
                        <span class="font-semibold">{{ $event->title }}</span>
                        <span class="text-gray-500">({{ $event->date }})</span>
                    </li>
                @endforeach
                </ul>
            </div>
            <div>
                <h2 class="font-bold text-lg mb-2">{{ __('Your Registered Opportunities') }}</h2>
                <ul>
                @foreach($opportunities ?? [] as $opp)
                    <li>
                        <span class="font-semibold">{{ $opp->title }}</span>
                        <span class="text-gray-500">({{ $opp->date }})</span>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>

        <div class="mt-8">
            <h2 class="font-bold text-lg mb-2">{{ __('Your Certificates') }}</h2>
            <ul>
            @foreach($certificates ?? [] as $cert)
                <li>
                    <a href="{{ route('volunteer.certificates.show', $cert->id) }}" class="text-blue-700 hover:underline">
                        {{ $cert->title }} ({{ $cert->issue_date }}, {{ $cert->hours }} {{ __('hours') }})
                    </a>
                </li>
            @endforeach
            </ul>
        </div>

        <div class="mt-8">
            <a href="{{ route('profile.edit') }}" class="text-blue-700 hover:underline mt-4 inline-block">{{ __('Edit Profile') }}</a>
            <a href="{{ route('volunteer.certificates') }}" class="ml-4 text-green-700 hover:underline mt-4 inline-block">{{ __('View All Certificates') }}</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const vctx = document.getElementById('volChart');
if(vctx){
    new Chart(vctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($volChart['labels'] ?? []) !!},
            datasets: [{
                label: '{{ __("Events") }}',
                data: {!! json_encode($volChart['data'] ?? []) !!},
                backgroundColor: 'rgba(36,107,253,0.4)'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: {display: false} }
        }
    });
}
</script>
@endsection
