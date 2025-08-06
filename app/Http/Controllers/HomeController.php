<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        // Get 3 most recent events
        $events = Event::orderBy('created_at', 'desc')->take(3)->get();
        return view('welcome', compact('events'));
    }
}
