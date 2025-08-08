@extends('layouts.admin_theme')
@section('content')
<div class="max-w-2xl mx-auto mt-10 p-8 bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-6">Payment API Keys</h2>
    <form>
        <label class="block mb-2 font-semibold">Stripe Secret Key:</label>
        <input type="text" name="stripe_secret" class="mb-4" disabled>
        <label class="block mb-2 font-semibold">PayTabs Server Key:</label>
        <input type="text" name="paytabs_server_key" class="mb-4" disabled>
        <p class="text-gray-400">Editing disabled until backend is connected.</p>
    </form>
</div>
@endsection
