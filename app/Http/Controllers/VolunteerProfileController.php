<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VolunteerProfileController extends Controller {
    public function show() {
        return view('volunteer.profile');
    }

    public function update(Request $request) {
        // Update logic here
        return redirect()->route('volunteer.profile')->with('success', 'Profile updated!');
    }
}
