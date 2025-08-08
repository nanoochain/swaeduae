<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('date','desc')->paginate(20);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'date'        => 'required|date',
            'location'    => 'nullable|string|max:255',
            'hours'       => 'nullable|numeric|min:0',
        ]);
        Event::create($data);
        return redirect()->route('admin.events.index')->with('ok','Event created');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'date'        => 'required|date',
            'location'    => 'nullable|string|max:255',
            'hours'       => 'nullable|numeric|min:0',
        ]);
        $event->update($data);
        return redirect()->route('admin.events.index')->with('ok','Event updated');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return back()->with('ok','Event deleted');
    }

    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }
}
