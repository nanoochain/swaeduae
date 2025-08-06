@extends('layouts.app')

@section('title', 'Volunteer Dashboard')

@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-8 max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-blue-900 mb-4">Welcome, {{ \$user->name }}!</h1>
        <div class="mb-6">
            <p class="text-lg">Profile: {{ \$user->email }}</p>
            <p class="text-lg">Total Volunteer Hours: <span class="font-bold">
                {{
                    \App\Models\Certificate::where('user_id', \$user->id)->sum('hours')
                }}
            </span></p>
        </div>
        <h2 class="font-bold mt-6 mb-2">Your Registered Events</h2>
        <ul>
        @foreach(\App\Models\Registration::where('user_id', \$user->id)->whereNotNull('event_id')->with('event')->get() as \$reg)
            <li>
                <span class="font-semibold">{{ \$reg->event->title ?? '' }}</span>
                <span class="text-gray-500">({{ \$reg->event->date ?? '' }})</span>
            </li>
        @endforeach
        </ul>
        <h2 class="font-bold mt-6 mb-2">Your Registered Opportunities</h2>
        <ul>
        @foreach(\App\Models\Registration::where('user_id', \$user->id)->whereNotNull('opportunity_id')->with('opportunity')->get() as \$reg)
            <li>
                <span class="font-semibold">{{ \$reg->opportunity->title ?? '' }}</span>
                <span class="text-gray-500">({{ \$reg->opportunity->date ?? '' }})</span>
            </li>
        @endforeach
        </ul>
        <h2 class="font-bold mt-6 mb-2">Your Certificates</h2>
        <ul>
        @foreach(\App\Models\Certificate::where('user_id', \$user->id)->get() as \$cert)
            <li>
                <a href="{{ route('volunteer.certificates.show', \$cert->id) }}" class="text-blue-700 hover:underline">
                    {{ \$cert->title }} ({{ \$cert->issue_date }}, {{ \$cert->hours }} hours)
                </a>
            </li>
        @endforeach
        </ul>
        <a href="{{ route('profile.edit') }}" class="text-blue-700 hover:underline mt-4 inline-block">Edit Profile</a>
        <a href="{{ route('volunteer.certificates') }}" class="ml-4 text-green-700 hover:underline mt-4 inline-block">View All Certificates</a>
    </div>
</div>
@endsection
