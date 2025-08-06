<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Opportunity;
use App\Models\Certificate;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'volunteers' => User::where('role', 'volunteer')->count(),
            'organizations' => User::where('role', 'organization')->count(),
            'events' => Event::count(),
            'opportunities' => Opportunity::count(),
            'certificates' => Certificate::count(),
            'pendingVolunteers' => User::where('role', 'volunteer')->where('status', 'pending')->get(),
        ]);
    }

    public function approveVolunteer($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'approved';
        $user->save();
        return back()->with('success', 'Volunteer approved!');
    }

    public function rejectVolunteer($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'rejected';
        $user->save();
        return back()->with('success', 'Volunteer rejected!');
    }
}
