<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class VolunteerRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('volunteer.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'volunteer',
        ]);

        auth()->login($user);

        return redirect()->route('volunteer.dashboard')->with('success', 'Registration successful!');
    }
}
