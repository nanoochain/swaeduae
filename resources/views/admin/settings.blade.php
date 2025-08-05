@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Site & API Settings</h2>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="row g-3">
        @csrf
        <h5>General Site</h5>
        <div class="col-md-6">
            <label>Site Name</label>
            <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label>Homepage Hero Text</label>
            <input type="text" name="homepage_hero" class="form-control" value="{{ $settings['homepage_hero'] ?? '' }}">
        </div>
        <div class="col-12">
            <label>Homepage Subtitle</label>
            <input type="text" name="homepage_subtitle" class="form-control" value="{{ $settings['homepage_subtitle'] ?? '' }}">
        </div>
        <div class="col-12">
            <label>Homepage Image</label>
            <input type="file" name="homepage_image" class="form-control">
            @if(!empty($settings['homepage_image']))
            <img src="{{ asset('storage/' . $settings['homepage_image']) }}" style="max-width:160px;" class="mt-2">
            @endif
        </div>

        <hr class="mt-4 mb-3">

        <h5>UAE PASS</h5>
        <div class="col-md-4">
            <label>Client ID</label>
            <input type="text" name="uaepass_client_id" class="form-control" value="{{ $settings['uaepass_client_id'] ?? '' }}">
        </div>
        <div class="col-md-4">
            <label>Client Secret</label>
            <input type="text" name="uaepass_client_secret" class="form-control" value="{{ $settings['uaepass_client_secret'] ?? '' }}">
        </div>
        <div class="col-md-4">
            <label>Redirect URI</label>
            <input type="text" name="uaepass_redirect_uri" class="form-control" value="{{ $settings['uaepass_redirect_uri'] ?? '' }}">
        </div>

        <hr class="mt-4 mb-3">

        <h5>Google Login</h5>
        <div class="col-md-6">
            <label>Google Client ID</label>
            <input type="text" name="google_client_id" class="form-control" value="{{ $settings['google_client_id'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label>Google Client Secret</label>
            <input type="text" name="google_client_secret" class="form-control" value="{{ $settings['google_client_secret'] ?? '' }}">
        </div>

        <hr class="mt-4 mb-3">

        <h5>Facebook Login</h5>
        <div class="col-md-6">
            <label>Facebook App ID</label>
            <input type="text" name="facebook_app_id" class="form-control" value="{{ $settings['facebook_app_id'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label>Facebook App Secret</label>
            <input type="text" name="facebook_app_secret" class="form-control" value="{{ $settings['facebook_app_secret'] ?? '' }}">
        </div>

        <hr class="mt-4 mb-3">

        <h5>WhatsApp</h5>
        <div class="col-md-4">
            <label>API Key</label>
            <input type="text" name="whatsapp_api_key" class="form-control" value="{{ $settings['whatsapp_api_key'] ?? '' }}">
        </div>
        <div class="col-md-4">
            <label>Instance ID</label>
            <input type="text" name="whatsapp_instance_id" class="form-control" value="{{ $settings['whatsapp_instance_id'] ?? '' }}">
        </div>
        <div class="col-md-4">
            <label>WhatsApp Number</label>
            <input type="text" name="whatsapp_number" class="form-control" value="{{ $settings['whatsapp_number'] ?? '' }}">
        </div>

        <hr class="mt-4 mb-3">

        <h5>Twilio SMS</h5>
        <div class="col-md-4">
            <label>Account SID</label>
            <input type="text" name="twilio_sid" class="form-control" value="{{ $settings['twilio_sid'] ?? '' }}">
    
        <div class="col-md-4">
            <label>Auth Token</label>
            <input type="text" name="twilio_token" class="form-control" value="{{ $settings['twilio_token'] ?? '' }}">
        </div>
        <div class="col-md-4">
            <label>Twilio Number</label>
 
        </div>

        <hr class="mt-4 mb-3">

        <h5>SMTP (Email Sending)</h5>
        <div class="col-md-4">
            <
            <input type="text
        </div>
        <div cl
            <label>Port</label>
    
        </div>
        <div class="col-md-3">
            <label>Username</label>
            <input type="text"
        </div>
        <div class="col-md-3">
            <label>Password</label>
         
        </div>

        <hr class="mt-4 mb-3">

        <h5>Analytics / Meta</h5>
        <div class="col-md-6">
       
            <i
        </div>
        <div 
            <label>Facebook Pixel ID</label>
            <input type="text" name="fb_pixel_id" class="form-control" value="{{ $settings['fb_pixel_id'] ?? '' }}">
        </d
        <div c
            <label>Meta Tags
            <textarea name="meta_tags" cl
        </div>

        <div class="col-12">
            <button class="bt
        </div>
    </form>
</div>
@endsection
