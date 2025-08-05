<?php

namespace App\Services;

use App\Models\Certificate;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateService
{
    public function generatePdf(Certificate $certificate)
    {
        $registration = $certificate->registration;
        $event = $registration->event;
        $volunteer = $registration->volunteer;

        $qrCode = QrCode::format('png')->size(200)->generate(route('certificate.verify', ['id' => $certificate->id]));

        $pdf = Pdf::loadView('certificates.pdf', [
            'certificate' => $certificate,
            'event' => $event,
            'volunteer' => $volunteer,
            'qrCode' => $qrCode,
        ]);

        $path = 'public/certificates/certificate_'.$certificate->id.'.pdf';
        $pdf->save(storage_path('app/'.$path));

        $certificate->file_path = $path;
        $certificate->issued_at = now();
        $certificate->save();

        return $path;
    }
}
