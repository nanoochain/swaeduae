<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function unread()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications()->get()->map(function($notif) {
            return [
                'id' => $notif->id,
                'message' => $notif->data['message'] ?? 'Notification',
                'url' => $notif->data['url'] ?? '#',
            ];
        });
        return response()->json([
            'count' => $notifications->count(),
            'notifications' => $notifications,
        ]);
    }
}
