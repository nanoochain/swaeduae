@extends('layouts.app')

@section('content')
    <h1>Opportunities</h1>
    <ul>
        @foreach($opps as $opp)
            <li>{{ $opp->title ?? 'Untitled' }}</li>
        @endforeach
    </ul>
    {{ $opps->links() }}
@endsection
