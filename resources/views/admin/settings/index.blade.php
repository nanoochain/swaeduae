@extends('layouts.admin_theme')
@section('title', 'Site Settings')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Settings</h2>
</div>
<div class="dashboard-card p-4">
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Site Name</label>
            <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Contact Email</label>
            <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Maintenance Mode</label>
            <select name="maintenance_mode" class="form-select">
                <option value="0" @if(!($settings['maintenance_mode'] ?? false)) selected @endif>No</option>
                <option value="1" @if(($settings['maintenance_mode'] ?? false)) selected @endif>Yes</option>
            </select>
        </div>
        <button class="btn btn-success">Save Changes</button>
    </form>
</div>
@endsection
