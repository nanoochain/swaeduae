<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function index() { return view('admin.logs.index'); }
}
