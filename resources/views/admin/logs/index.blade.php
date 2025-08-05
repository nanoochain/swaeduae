@extends('layouts.admin_theme')
@section('title', 'Activity Logs')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>System Activity Logs</h2>
    <form method="GET" class="d-inline-block">
        <input type="text" name="search" class="form-control" placeholder="Search logs..." value="{{ request('search') }}">
    </form>
</div>
<div class="dashboard-card table-responsive p-0">
    <table class="table align-middle mb-0">
        <thead>
            <tr><th>#</th><th>User</th><th>Action</th><th>Date</th></tr>
        </thead>
        <tbody>
            @forelse($logs ?? [] as $log)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $log->user->name ?? '-' }}</td>
                    <td>{{ $log->
                    <td>{{ $log->cr
                </tr>
            @empt
                <tr><td colspan="4">No l

        </tbody>
    </table>
</div>
@endsection
