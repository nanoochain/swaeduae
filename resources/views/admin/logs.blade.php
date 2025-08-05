@extends('layouts.admin')
@section('title', 'System Logs')
@section('content')
<div class="py-8 px-6 max-w-3xl">
    <h1 class="text-2xl font-bold mb-6 text-blue-800">System Logs</h1>
    <div class="bg-gray-900 text-green-400 p-4 rounded shadow overflow-x-auto text-xs max-h-[500px]">
        <pre>@foreach($logs as $log){{ $log }}@endforeach</pre>
    </div>
</div>
@endsection
