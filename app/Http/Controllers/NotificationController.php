<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function getNotifications(Request $request)
    {
        $user = Auth::user();

        $notifications = Notification::where('destination_user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->get();
            $notifications->load('sourceUser.images');

        return response()->json(['notifications' => $notifications]);
    }
}
