<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opportunity;
use App\Models\Event;
use App\Models\User;
use App\Models\VolunteerHour;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Opportunity::where('featured', true)->latest()->take(4)->get();
        $stats = [
            'volunteers' => User::count(),
            'events'     => Event::count(),
            'hours'      => VolunteerHour::sum('hours'),
        ];
        return view('public.home', compact('featured', 'stats'));
    }
}
