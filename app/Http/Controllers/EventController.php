<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $q = Event::query();

        if ($request->filled('search')) {
            $s = '%'.$request->get('search').'%';
            $q->where(function($w) use ($s){
                $w->where('title','like',$s)
                  ->orWhere('location','like',$s)
                  ->orWhere('description','like',$s);
            });
        }

        $events = $q->orderBy('date')->paginate(12);
        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
}
