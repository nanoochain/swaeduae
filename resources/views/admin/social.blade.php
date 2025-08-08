@extends('layouts.admin_theme')
@section('content')
<div class="max-w-2xl mx-auto mt-10 p-8 bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-6">Social API Keys</h2>
    <form>
        <label class="block mb-2 font-semibold">Facebook App ID:</label>
        <input type="text" name="facebook_app_id" class="mb-4" disabled>
        <label class="block mb-2 font-semibold">Google Client ID:</label>
        <input type="text" name="google_client_id" class="mb-4" disabled>
        <p class="text-gray-400">Editing disabled until backend is connected.</p>
    </form>
</div>
@endsection
