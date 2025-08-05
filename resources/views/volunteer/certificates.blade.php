@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">📄 الشهادات</h1>
    @foreach($certificates as $cert)
        <div class="mb-3 p-4 border rounded">
            <strong>{{ $cert->title }}</strong>
            <a href="{{ route('certificate.pdf', $cert->id) }}" class="btn btn-sm btn-success">تحميل PDF</a>
        </div>
    @endforeach
</div>
@endsection
