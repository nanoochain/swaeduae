<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateController extends Controller
{
    public function download($id)
    {
        $certificate = Certificate::findOrFail($id);
        $qr = base64_encode(QrCode::format('png')->size(130)->generate(route('certificates.verify', ['code' => $certificate->code])));
        $pdf = Pdf::loadView('certificates.pdf', compact('certificate', 'qr'));
        return $pdf->download('certificate_'.$certificate->code.'.pdf');
    }
}
