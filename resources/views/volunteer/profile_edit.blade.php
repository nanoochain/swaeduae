@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Edit Profile</h1>
    <form method="POST" action="{{ route('volunteer.profile.update') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label>Bio:</label>
            <input type="text" name="bio" value="{{ old('bio', $profile->bio) }}">
        </div>
        <div>
            <label>Phone:</label>
            <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}">
        </div>
        <div>
            <label>KYC Document (PDF/JPG):</label>
            <input type="file" name="kyc_document" accept="application/pdf,image/*">
        </div>
        <div>
            <label>Profile Picture:</label>
            <input type="file" name="profile_picture" accept="image/*">
        </div>
        <button type="submit">Save</button>
        <a href="{{ route('volunteer.profile.show') }}">Cancel</a>
    </form>
</div>
@endsection
