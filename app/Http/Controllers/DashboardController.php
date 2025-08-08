<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // TODO: Fetch data for user dashboard
        return view('dashboard.index'); // Create this Blade view
    }
}
