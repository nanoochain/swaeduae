<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Opportunity;

class DashboardController extends Controller
{
    public function index()
    {
        $org = Auth::user();
        $events = Event::where('organization_id', $org->id)->get();
        $opportunities = Opportunity::where('organization_id', $org->id)->get();
        return view('organization.dashboard', compact('org', 'events', 'opportunities'));
    }

    public function createEvent()
    {
        return view('organization.create_event');
    }

    public function storeEvent(Request $request)
    {
        $org = Auth::user();
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date' => 'required|date'
        ]);
        $data['organization_id'] = $org->id;
        Event::create($data);
        return redirect()->route('organization.dashboard')->with('success', 'Event created!');
    }
}
