<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class OrganizationController extends Controller
{
    public function index()   { return view('admin.organizations.index'); }
    public function show($id) { return view('admin.organizations.show', compact('id')); }
    public function edit($id) { return view('admin.organizations.edit', compact('id')); }
}
