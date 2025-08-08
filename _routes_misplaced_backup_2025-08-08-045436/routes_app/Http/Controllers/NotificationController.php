<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function fetch()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications()->get()->map(function ($notif) {
            return [
                'id' => $notif->id,
                'message' => $notif->data['message'] ?? 'Notification',
                'created_at' => $notif->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'count' => $notifications->count(),
            'notifications' => $notifications,
        ]);
    }
}
