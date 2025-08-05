@extends('layouts.admin_theme')
@section('title', __('Manage Volunteers'))
@section('content')
<h2>{{ $event->title }} – {{ __('Volunteers') }}</h2>
<form method="POST" action="{{ route('admin.events.volunteers.bulk', $event->id) }}">
    @csrf
    <div class="mb-3">
        <button name="action" value="approve" class="btn btn-success btn-sm">{{ __('Approve Selected') }}</button>
        <button name="action" value="reject" class="btn btn-danger btn-sm">{{ __('Reject Selected') }}</button>
    </div>
    <div class="dashboard-card table-responsive p-0">
        <table class="table">
            <thead>
                <tr>
                    <th><input type="checkbox" onclick="$('.bulk-chk').prop('checked',this.checked);"></th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Status') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($event->registrations as $reg)
                <tr>
                    <td><input type="checkbox" name="ids[]" value="{{ $reg->id }}" class="bulk-chk"></td>
                    <td>{{ $reg->user->name ?? '' }}</td>
                    <td>{{ $reg->user->email ?? '' }}</td>
                    <td>
                        @if($reg->status=='approved')
                            <span class="badge bg-success">{{ __('Approved') }}</span>
                        @elseif($reg->status=='pending')
                            <span class="badge bg-warning">{{ __('Pending') }}</span>
                        @else
                            <span class="badge bg-danger">{{ __('Rejected') }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</form>
@endsection
