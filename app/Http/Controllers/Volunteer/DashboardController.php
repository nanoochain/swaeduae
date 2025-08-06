<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        \$user = Auth::user();
        // Placeholder stats/data, update as you build features
        \$registeredEvents = [];
        \$registeredOpportunities = [];
        \$certificates = [];
        \$volunteerHours = 0;
        return view('volunteer.dashboard', compact('user', 'registeredEvents', 'registeredOpportunities', 'certificates', 'volunteerHours'));
    }
}
