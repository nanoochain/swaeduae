<?php

namespace App\Http\Controllers;

use App\Models\Certificate;

class CertificateController extends Controller
{
    public function verify($code)
    {
        $certificate = Certificate::where('code',$code)->first();
        return view('certificates.verify', [
            'found' => (bool)$certificate,
            'certificate' => $certificate,
        ]);
    }
}
