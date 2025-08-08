@extends('layouts.admin_theme')

@section('content')
<h1>Site Settings</h1>
<form method="POST" action="{{ route('admin.settings.update') }}">
@csrf
<label>Site Name</label>
<input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}" />
<label>Site Email</label>
<input type="email" name="site_email" value="{{ $settings['site_email'] ?? '' }}" />
<label>Facebook URL</label>
<input type="url" name="facebook" value="{{ $settings['facebook'] ?? '' }}" />
<label>Twitter URL</label>
<input type="url" name="twitter" value="{{ $settings['twitter'] ?? '' }}" />
<label>Instagram URL</label>
<input type="url" name="instagram" value="{{ $settings['instagram'] ?? '' }}" />
<button type="submit">Save Settings</button>
</form>
@endsection
