<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Certificate;

class CertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $certificate;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    public function build()
    {
        return $this->subject('Your Certificate from Sawaed UAE')
            ->view('emails.certificate')
            ->attachData(
                \PDF::loadView('certificates.pdf', ['certificate' => $this->certificate])->output(),
                'certificate.pdf'
            );
    }
}
