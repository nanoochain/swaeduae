<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CertificateVerifyController extends Controller
{
    /**
     * Public: verify a certificate by numeric ID
     * URL: /verify/{id}
     */
    public function verify($id)
    {
        $cert = DB::table('certificates')->where('id', $id)->first();

        if (!$cert) {
            return view('certificates.verify', [
                'found' => false,
                'id'    => $id,
            ]);
        }

        $user  = DB::table('users')->where('id', $cert->user_id)->first();
        $event = DB::table('events')->where('id', $cert->event_id)->first();

        return view('certificates.verify', [
            'found' => true,
            'id'    => $id,
            'cert'  => $cert,
            'user'  => $user,
            'event' => $event,
        ]);
    }
}
