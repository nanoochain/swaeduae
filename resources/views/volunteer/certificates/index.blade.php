@extends('layouts.app')

@section('content')
<h1>My Certificates</h1>

@if(count($certificates) > 0)
<ul>
@foreach($certificates as $certificate)
<li>
    <a href="{{ route('certificates.show', $certificate->id) }}">{{ $certificate->title }}</a>
</li>
@endforeach
</ul>
@else
<p>No certificates found.</p>
@endif

<a href="{{ route('volunteer.dashboard') }}">Back to Dashboard</a>
@endsection
