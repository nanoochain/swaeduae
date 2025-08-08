<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::paginate(15);
        return view('admin.certificates.index', compact('certificates'));
    }

    public function create()
    {
        return view('admin.certificates.create');
    }

    public function store(Request $request)
    {
        Certificate::create($request->all());
        return redirect()->route('admin.certificates.index')->with('success', 'Certificate created.');
    }

    public function edit($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('admin.certificates.edit', compact('certificate'));
    }

    public function update(Request $request, $id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->update($request->all());
        return redirect()->route('admin.certificates.index')->with('success', 'Certificate updated.');
    }

    public function show($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('admin.certificates.show', compact('certificate'));
    }
}
