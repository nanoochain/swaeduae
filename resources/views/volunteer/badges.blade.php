@extends('layouts.theme'
@section('title', 'My Badges &
@section('content')
<div class="conta
    <h1 class="display-6 mb-4">
    <div class="row">
        @f
            <div class="col-auto 

                <div>{{ $badge->name }}
                <small class="text-muted">{{ $badge->d
            </d
        @empty
            <div class="alert alert-info">No badges earned yet. Participate more to earn
      
    </div>
</div>
@endsect
