@extends('layouts.admin_theme')

@section('content')
<h1>System Logs</h1>
<pre style="max-height:500px;overflow:auto;background:#f9f9f9;padding:10px;">
@foreach($logs as $log)
{{ $log }}
@endforeach
</pre>
@endsection
