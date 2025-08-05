<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    public function showRegister()
    {
        return view('organization.register');
    }
    public function register(Request \$request)
    {
        \$request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:organizations,email',
            'password' => 'required|confirmed|min:6',
        ]);
        Organization::create([
            'name' => \$request->name,
            'email' => \$request->email,
            'password' => Hash::make(\$request->password),
            'address' => \$request->address,
            'kyc_document' => null,
        ]);
        return redirect()->route('organization.login')->with('success', 'Registered! Please login.');
    }
    public function showLogin()
    {
        return view('organization.login');
    }
    public function login(Request \$request)
    {
        \$org = Organization::where('email', \$request->email)->first();
        if(\$org && Hash::check(\$request->password, \$org->password)) {
            session(['org_id' => \$org->id]);
            return redirect()->route('organization.dashboard');
        }
        return back()->withErrors(['email' => 'Invalid login']);
    }
    public function dashboard()
    {
        \$orgId = session('org_id');
        \$org = Organization::findOrFail(\$orgId);
        \$events = \$org->events()->get();
        return view('organization.dashboard', compact('org','events'));
    }
    public function logout()
    {
        session()->forget('org_id');
        return redirect()->route('organization.login');
    }
}
