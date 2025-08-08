#!/bin/bash

# ======= Expanded VolunteerController =======
cat > app/Http/Controllers/VolunteerController.php << 'EOVC'
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Certificate;
use App\Models\Badge;

class VolunteerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $hours = $user->volunteer_hours ?? 0; // Example: should be from DB relation
        $events = Event::whereHas('registrations', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();
        $certificates = Certificate::where('user_id', $user->id)->count();
        $badges = Badge::where('user_id', $user->id)->count();

        $nextEvent = Event::whereDate('date', '>=', now())->orderBy('date')->first();

        return view('volunteer.dashboard', compact('hours', 'events', 'certificates', 'badges', 'nextEvent'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('volunteer.profile_edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        $user->update($data);
        return redirect()->route('volunteer.dashboard')->with('success', 'Profile updated.');
    }
}
EOVC

# ======= Expanded EventController =======
cat > app/Http/Controllers/EventController.php << 'EOEC'
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('date', 'desc')->paginate(10);
        return view('events.index', compact('events'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('events.show', compact('event'));
    }
}
EOEC

# ======= Expanded OpportunityController =======
cat > app/Http/Controllers/OpportunityController.php << 'EOOC'
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    public function index(Request $request)
    {
        $query = Opportunity::query();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%$search%");
        }

        $opportunities = $query->paginate(10);

        return view('opportunities.index', compact('opportunities'));
    }
}
EOOC

# ======= Expanded CertificateController =======
cat > app/Http/Controllers/CertificateController.php << 'EOCC'
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $certificates = Certificate::where('user_id', $user->id)->paginate(10);
        return view('certificates.index', compact('certificates'));
    }

    public function show($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('certificates.show', compact('certificate'));
    }
}
EOCC

# ======= Search/Filter UI enhancements in opportunities/index.blade.php =======
cat > resources/views/opportunities/index.blade.php << 'EOF'
@extends('layouts.app')

@section('content')
<h1>Opportunities</h1>

<form method="GET" action="{{ route('opportunities.index') }}" class="mb-4">
    <input type="text" name="search" placeholder="{{ __('messages.search_placeholder') }}" value="{{ request('search') }}" class="border p-2 rounded w-1/2" />
    <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded ml-2">{{ __('messages.search') }}</button>
</form>

@if($opportunities->count())
    <ul>
        @foreach($opportunities as $opportunity)
            <li>{{ $opportunity->title }}</li>
        @endforeach
    </ul>

    {{ $opportunities->links() }}
@else
    <p>{{ __('messages.no_opportunities_found') ?? 'No opportunities found.' }}</p>
@endif
@endsection
