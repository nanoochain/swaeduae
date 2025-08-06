<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Certificate;
use App\Models\VolunteerHour;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $certificates = Certificate::where('user_id', $user->id)->get();
        $hours = VolunteerHour::where('user_id', $user->id)->sum('hours');
        $events = Event::whereHas('registrations', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        return view('volunteer.profile_dashboard', compact('user', 'certificates', 'hours', 'events'));
    }
}
