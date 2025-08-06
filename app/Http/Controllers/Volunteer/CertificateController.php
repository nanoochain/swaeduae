<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificate;

class CertificateController extends Controller
{
    public function index()
    {
        \$user = Auth::user();
        \$certificates = \$user->certificates;
        return view('volunteer.certificates', compact('certificates'));
    }

    public function show(\$id)
    {
        \$certificate = Certificate::findOrFail(\$id);
        \$this->authorize('view', \$certificate); // (Optional: Add policy for more security)
        return view('volunteer.certificate_show', compact('certificate'));
    }

    // You can add download logic here later
}
