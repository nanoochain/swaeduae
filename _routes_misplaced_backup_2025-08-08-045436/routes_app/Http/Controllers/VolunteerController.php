<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function index()
    {
        return view('volunteer.dashboard');
    }

    public function showProfile()
    {
        return view('volunteer.profile');
    }

    public function updateProfile(Request $request)
    {
        // Validate and save volunteer profile updates here
        return redirect()->route('volunteer.dashboard')->with('success', 'Profile updated.');
    }
}
