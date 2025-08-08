<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\VolunteerHour;
use App\Models\Certificate;

class VolunteerController extends Controller
{
    public function profile()
    {
        $user = Auth::user();

        $hours = VolunteerHour::where('user_id', $user->id)
            ->orderBy('date','desc')->get();

        $total_hours = $hours->sum('hours');

        $certificates = Certificate::where('user_id', $user->id)
            ->orderBy('created_at','desc')->get();

        return view('volunteer.profile', compact('user','hours','total_hours','certificates'));
    }
}
