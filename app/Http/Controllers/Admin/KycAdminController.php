<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class KycAdminController extends Controller
{
    public function index()   { return view('admin.kyc.index'); }
    public function show($id) { return view('admin.kyc.index', compact('id')); }
}
