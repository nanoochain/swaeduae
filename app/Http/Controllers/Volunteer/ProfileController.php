<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        return view('volunteer.dashboard');
    }

    // Show profile
    public function show()
    {
        return view('volunteer.profile');
    }

    // Edit profile
    public function edit()
    {
        return view('volunteer.profile_edit');
    }

    // Certificates
    public function certificates()
    {
        return view('volunteer.certificates');
    }

    // Leaderboard
    public function leaderboard()
    {
        return view('volunteer.leaderboard');
    }

    // Badges
    public function badges()
    {
        return view('volunteer.badges');
    }

    // My Events
    public function myEvents()
    {
        return view('volunteer.my_events');
    }

    // Hours
    public function hours()
    {
        return view('volunteer.hours');
    }
}
