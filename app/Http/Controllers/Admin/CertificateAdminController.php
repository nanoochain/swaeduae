<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Mail\CertificateMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class CertificateAdminController extends Controller
{
    public function send($id)
    {
        $certificate = Certificate::with(['user', 'event'])->findOrFail($id);

        Mail::to($certificate->user->email)->send(new CertificateMail($certificate));

        // Stub: Send via WhatsApp (replace with Twilio or 360Dialog if needed)
        // Log or simulate:
        \Log::info("WhatsApp sent to: " . $certificate->user->phone);

        return redirect()->back()->with('success', 'Certificate sent via Email (and WhatsApp simulated).');
    }
}
