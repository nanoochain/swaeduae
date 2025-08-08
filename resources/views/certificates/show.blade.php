@extends('layouts.app')

@section('content')
<h1>Certificate: {{ $certificate->title }}</h1>

<p>Issued on: {{ $certificate->issue_date }}</p>

<div>
    {!! QrCode::size(150)->generate(route('certificates.verify', $certificate->id)) !!}
</div>

<a href="{{ route('certificates.index') }}">Back to Certificates</a>
@endsection
