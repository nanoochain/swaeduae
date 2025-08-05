<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $events = $query->orderBy('date', 'asc')->get();

        return view('events.index', compact('events'));
    }
}
