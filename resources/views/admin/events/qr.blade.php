@extends('layouts.admin_theme')
@section('title', __('Event QR Attendance'))
@section('content')
<h2>{{ $event->title }}</h2>
<img src="data:image/png;base64,{{ $qr }}" alt="QR Code">
@endsection
