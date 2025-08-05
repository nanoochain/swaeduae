<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;

class CertificateVerifyController extends Controller
{
    public function verify($certNumber)
    {
        $cert = Certificate::where('certificate_number', $certNumber)->firstOrFail();
        return view('certificates.verify', compact('cert'));
    }
}
