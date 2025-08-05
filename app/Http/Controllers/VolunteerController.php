<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;

class VolunteerController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $hours = $user->volunteer_hours ?? 0;
        $events_count = $user->events()->count() ?? 0;
        $recent_events = $user->events()->latest('date')->take(5)->get() ?? [];
        return view('volunteer.profile', compact('user', 'hours', 'events_count', 'recent_events'));
    }

    // Downloadable PDF resume (stub logic)
    public function resume()
    {
        // This should generate a PDF, but for now we'll just return a view
        $user = Auth::user();
        $events = $user->events()->orderBy('date', 'desc')->get() ?? [];
        return view('volunteer.resume', compact('user', 'events'));
    }
}
