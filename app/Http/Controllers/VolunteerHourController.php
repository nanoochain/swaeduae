<?php

namespace App\Http\Controllers;

use App\Models\VolunteerHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerHourController extends Controller
{
    public function index()
    {
        $hours = VolunteerHour::where('user_id', Auth::id())->get();
        return view('volunteer.hours', compact('hours'));
    }

    public function store(Request $request)
    {
        VolunteerHour::create([
            'user_id' => Auth::id(),
            'event_id' => $request->event_id,
            'hours' => $request->hours,
        ]);
        return back()->with('success', 'Hours logged.');
    }
}
