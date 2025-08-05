<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventPhotoController extends Controller
{
    public function show($eventId)
    {
        $event = Event::findOrFail($eventId);
    
        ret
    }


   
        $event = Event::findOrFail($eventId);
        if($request->hasFile('photos')) {
            foreach($request->file('photos') as $photo) {
                $path = $photo->store('event_photos', 'public');
                $photos = $event->photos ?? [];
                $p
 
                $event->save(
            }
        }
     
    }
}
