@extends('layouts.app')
@section('title', 'Event QR Code')
@section('content')
<h1>QR Code for {{ $event->title }}</h1>
<div>{!! $qr !!}</div>
<p>Use this QR code to check in volunteers.</p>
@endsection
