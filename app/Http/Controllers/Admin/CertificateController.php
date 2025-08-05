<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CertificateController extends Controller
{
    public function index()   { return view('admin.certificates.index'); }
    public function create()  { return view('admin.certificates.create'); }
    public function show($id) { return view('admin.certificates.show', compact('id')); }
    public function edit($id) { return view('admin.certificates.edit', compact('id')); }
}
