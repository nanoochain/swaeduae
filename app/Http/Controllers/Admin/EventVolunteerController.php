<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;

class EventVolunteerController extends Controller
{
    public function index($e
    {
        $event = Event::with('registrations.user')->findOrFail($even
        return view('admin.events.volunteers
    }

    public function bulkAction(Request $request, $eventId)
    {
   
        $ids = $request->input('ids', []);
        if ($
            EventRegistration::whereIn('id', $ids)->update(['status' => 'approved']);
   
            EventRegistration::whereIn('id', $ids)->update(['status' 
        }
        return back()->with('success', 'Bulk action completed!');
    }
}
