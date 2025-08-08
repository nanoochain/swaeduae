@extends('layouts.admin_theme')
@section('content')
<div class="max-w-2xl mx-auto mt-10 p-8 bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-6">UAE PASS & SSO Integration</h2>
    <form>
        <label class="block mb-2 font-semibold">UAE PASS Client ID:</label>
        <input type="text" name="uaepass_client_id" class="mb-4" disabled>
        <label class="block mb-2 font-semibold">UAE PASS Client Secret:</label>
        <input type="text" name="uaepass_client_secret" class="mb-4" disabled>
        <p class="text-gray-400">Editing disabled until backend is connected.</p>
    </form>
</div>
@endsection
