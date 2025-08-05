<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PartnerController extends Controller
{
    public function index()   { return view('admin.partners.index'); }
    public function create()  { return view('admin.partners.create'); }
    public function edit($id) { return view('admin.partners.edit', compact('id')); }
}
