<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Certificate;
use App\Models\Kyc;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class VolunteerController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $hours = $user->volunteer_hours ?? 0;
        $events_count = $user->events()->count() ?? 0;
        $recent_events = $user->events()->latest('date')->take(5)->get() ?? [];
        $certificates = Certificate::where('user_id', $user->id)->get();
        $kyc = Kyc::where('user_id', $user->id)->first();

        return view('volunteer.profile', compact('user', 'hours', 'events_count', 'recent_events', 'certificates', 'kyc'));
    }

    // Event registration form submission
    public function registerEvent(Request $request, $eventId)
    {
        $user = Auth::user();
        $event = Event::findOrFail($eventId);

        // Check if already registered
        if ($user->events()->where('event_id', $eventId)->exists()) {
            return back()->with('error', 'You are already registered for this event.');
        }

        $user->events()->attach($eventId, ['status' => 'pending']);
        // Send admin notification (stub)
        // Mail::to(config('app.admin_email'))->send(new NewEventRegistration($user, $event));

        return back()->with('success', 'Registration submitted. Awaiting approval.');
    }

    // KYC upload form
    public function uploadKyc(Request $request)
    {
        $request->validate([
            'kyc_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('kyc_document')) {
            $file = $request->file('kyc_document');
            $path = $file->store('kyc_docs', 'public');

            $kyc = Kyc::updateOrCreate(
                ['user_id' => $user->id],
                ['document_path' => $path, 'status' => 'pending']
            );

            // Send notification to admin (stub)
            // Mail::to(config('app.admin_email'))->send(new KycUploadedNotification($user));

            return back()->with('success', 'KYC document uploaded successfully. Awaiting approval.');
        }

        return back()->with('error', 'Please upload a valid document.');
    }

    // Volunteer resume download stub
    public function resume()
    {
        $user = Auth::user();
        $events = $user->events()->orderBy('date', 'desc')->get() ?? [];
        return view('volunteer.resume', compact('user', 'events'));
    }

    // Certificate generation stub (to be extended with real PDF lib)
    public function generateCertificate($certId)
    {
        $certificate = Certificate::findOrFail($certId);
        // Stub: return simple view or PDF placeholder
        return view('volunteer.certificate', compact('certificate'));
    }
}
