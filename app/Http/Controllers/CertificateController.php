<?php
namespace App\Http\Controllers;

class CertificateController extends Controller {
    public function index() {
        return view('certificates.index');
    }

    public function show($id) {
        return view('certificates.show', compact('id'));
    }

    public function adminIndex() {
        return view('admin.certificates.index');
    }

    public function create() {
        return view('admin.certificates.create');
    }

    public function adminShow($id) {
        return view('admin.certificates.show', compact('id'));
    }
}
