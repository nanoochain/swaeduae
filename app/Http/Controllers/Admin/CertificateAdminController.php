<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateAdminController extends Controller
{
    public function index()
    {
        $certificates = Certificate::orderBy('issue_date', 'desc')->paginate(20);
        return view('admin.certificates.index', compact('certificates'));
    }

    public function show($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('admin.certificates.show', compact('certificate'));
    }

    public function create()
    {
        return view('admin.certificates.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'issue_date' => 'required|date',
            'hours' => 'nullable|numeric',
            'pdf' => 'nullable|file|mimes:pdf',
            'status' => 'required|string',
        ]);

        if ($request->hasFile('pdf')) {
            $data['pdf'] = $request->file('pdf')->store('certificates');
        }

        Certificate::create($data);

        return redirect()->route('admin.certificates.index')->with('success', 'Certificate created successfully.');
    }

    public function edit($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('admin.certificates.edit', compact('certificate'));
    }

    public function update(Request $request, $id)
    {
        $certificate = Certificate::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'issue_date' => 'required|date',
            'hours' => 'nullable|numeric',
            'pdf' => 'nullable|file|mimes:pdf',
            'status' => 'required|string',
        ]);

        if ($request->hasFile('pdf')) {
            $data['pdf'] = $request->file('pdf')->store('certificates');
        }

        $certificate->update($data);

        return redirect()->route('admin.certificates.index')->with('success', 'Certificate updated successfully.');
    }

    public function destroy($id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->delete();

        return redirect()->route('admin.certificates.index')->with('success', 'Certificate deleted successfully.');
    }
}
