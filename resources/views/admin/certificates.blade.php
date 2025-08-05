@extends('layouts.app')
@section('title', 'Manage Certificates')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-8">Certificates</h1>
    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-3 py-2">ID</th>
                <th class="border border-gray-300 px-3 py-2">User ID</th>
                <th class="border border-gray-300 px-3 py-2">Event ID</th>
                <th class="border border-gray-300 px-3 py-2">Code</th>
                <th class="border border-gray-300 px-3 py-2">Status</th>
                <th class="border border-gray-300 px-3 py-2">Issued At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($certs as $c)
            <tr>
                <td class="border border-gray-300 px-3 py-2">{{ $c->id }}</td>
                <td class="border border-gray-300 px-3 py-2">{{ $c->user_id }}</td>
                <td class="border border-gray-300 px-3 py-2">{{ $c->event_id ?? 'N/A' }}</td>
                <td class="border border-gray-300 px-3 py-2">{{ $c->certificate_code }}</td>
                <td class="border border-gray-300 px-3 py-2">{{ ucfirst($c->status) }}</td>
                <td class="border border-gray-300 px-3 py-2">{{ $c->issued_at ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $certs->links() }}</div>
</div>
@endsection
