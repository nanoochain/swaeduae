@extends('layouts.app')
@section('title', __('Volunteer Dashboard'))
@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="dashboard-card p-4 text-center">
            <i class="bi bi-person-circle fs-1 brand"></i>
            <div class="fs-5">{{ __('My Certificates') }}</div>
            <div class="fs-3">{{ $certCount ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="dashboard-card p-4 text-center">
            <i class="bi bi-clock fs-1 brand"></i>
            <div class="fs-5">{{ __('Total Volunteer Hours') }}</div>
            <div class="fs-3">{{ $hours ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="dashboard-card p-4 text-center">
            <i class="bi bi-calendar-event fs-1 brand"></i>
            <div class="fs-5">{{ __('Upcoming Events') }}</div>
            <div class="fs-3">{{ $upcoming ?? 0 }}</div>
        </div>
    </div>
</div>
<div class="row g-4 mt-4">
    <div class="col-lg-8">
        <div class="dashboard-card p-4">
            <h5>{{ __('My Participation Over Time') }}</h5>
            <canvas id="volChart" height="120"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="dashboard-card p-4">
            <h5>{{ __('Badges & Achievements') }}</h5>
            <ul class="list-unstyled" style="max-height: 160px; overflow:auto;">
                @foreach($badges ?? [] as $badge)
                    <li class="mb-2"><i class="bi bi-patch-check-fill text-success"></i> {{ $badge }}</li>
                @endforeach
            </ul>
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
