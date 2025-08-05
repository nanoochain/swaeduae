<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index() {
        return view('admin.events');
    }
    // Add other methods as needed: create, edit, show, etc.
}
