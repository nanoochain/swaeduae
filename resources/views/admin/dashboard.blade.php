@extends('layouts.admin_theme')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded shadow flex flex-col items-center">
            <div class="text-2xl font-bold text-blue-900">{{ $usersCount }}</div>
            <div class="text-gray-600 mt-2">Total Users</div>
        </div>
        <div class="bg-white p-6 rounded shadow flex flex-col items-center">
            <div class="text-2xl font-bold text-green-600">{{ $eventsCount }}</div>
            <div class="text-gray-600 mt-2">Events</div>
        </div>
        <div class="bg-white p-6 rounded shadow flex flex-col items-center">
            <div class="text-2xl font-bold text-orange-600">{{ $volunteersCount }}</div>
            <div class="text-gray-600 mt-2">Volunteers</div>
        </div>
        <div class="bg-white p-6 rounded shadow flex flex-col items-center">
            <div class="text-2xl font-bold text-purple-600">{{ $certificatesIssued }}</div>
            <div class="text-gray-600 mt-2">Certificates Issued</div>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow mb-8">
        <h2 class="text-xl font-bold mb-4">Users Growth Over Time</h2>
        <canvas id="usersChart" height="120"></canvas>
    </div>

    <div class="bg-white p-6 rounded shadow mb-8">
        <h2 class="text-xl font-bold mb-4">Volunteer Hours Over Time</h2>
        <canvas id="volunteerHoursChart" height="120"></canvas>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Events Over Time</h2>
        <canvas id="eventsChart" height="120"></canvas>
    </div>

    <script>
        const ctxUsers = document.getElementById('usersChart').getContext('2d');
        const usersChart = new Chart(ctxUsers, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Users',
                    data: @json($userGrowth),
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });

        const ctxVolunteerHours = document.getElementById('volunteerHoursChart').getContext('2d');
        const volunteerHoursChart = new Chart(ctxVolunteerHours, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Volunteer Hours',
                    data: @json($volunteerHours),
                    backgroundColor: 'rgba(234, 88, 12, 0.7)'
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });

        const ctxEvents = document.getElementById('eventsChart').getContext('2d');
        const eventsChart = new Chart(ctxEvents, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Events',
                    data: @json($eventsOverTime),
                    backgroundColor: 'rgba(34, 197, 94, 0.4)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });
    </script>
@endsection
