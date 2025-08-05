<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function approveKyc($id)
    {
        // KYC approval logic stub
        return redirect()->back()->with('success', 'KYC Approved!');
    }
}
