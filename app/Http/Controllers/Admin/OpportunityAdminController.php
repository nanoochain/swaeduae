<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use Illuminate\Http\Request;

class OpportunityAdminController extends Controller
{
    // Show form to create a new opportunity
    public function create()
    {
        return view('admin.opportunities.create');
    }

    // Store a new opportunity
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
        ]);
        Opportunity::create($validated);
        return redirect()->route('admin.opportunities.create')->with('success', 'Opportunity added!');
    }
}
