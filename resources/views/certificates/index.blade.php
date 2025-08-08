@extends('layouts.app')

@section('content')
<h1>My Certificates</h1>

@if($certificates->count())
<ul>
    @foreach($certificates as $certificate)
        <li>
            <a href="{{ route('certificates.show', $certificate->id) }}">{{ $certificate->title }}</a> - Issued: {{ $certificate->issue_date->format('Y-m-d') }}
        </li>
    @endforeach
</ul>

{{ $certificates->links() }}
@else
<p>You have no certificates yet.</p>
@endif

@endsection
