<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="dashboard-card p-4 text-center">
            <div class="fs-2 brand"><i class="bi bi-clock"></i></div>
            <div class="fs-5">Total Hours</div>
            <div class="fs-3">{{ $totalHours ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="dashboard-card p-4 text-center">
            <div class="fs-2 brand"><i class="bi bi-calendar-event"></i></div>
            <div class="fs-5">Upcoming Events</div>
            <div class="fs-3">{{ $upcomingEvents ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="dashboard-card p-4 text-center">
            <div class="fs-2 brand"><i class="bi bi-award"></i></div>
            <div class="fs-5">Badges</div>
            <div class="fs-3">{{ $badgesCount ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="dashboard-card p-4 text-center">
            <div class="fs-2 brand"><i class="bi bi-mortarboard"></i></div>
            <div class="fs-5">Certificates</div>
            <div class="fs-3">{{ $certificatesCount ?? 0 }}</div>
        </div>
    </div>
</div>
