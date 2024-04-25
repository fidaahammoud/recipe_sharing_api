<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class NotificationController extends Controller
{
    public function getNotifications(Request $request,User $user)
    {
       
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    
        if ($request->user()->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }


        //$user = Auth::user();

        $notifications = Notification::where('destination_user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->get();
            $notifications->load('sourceUser.images');

        return response()->json(['notifications' => $notifications]);
    }


    public function updateStatusNotification(Request $request, User $user, Notification $notification)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        Log::Info($request);
        Log::Info($user);
        Log::Info($notification);
        try {
            
            if ($notification->destination_user_id !== $user->id) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
    
            if ($notification->isRead) { 
                $notification->update(['isRead' => false]);
                return response()->json(['message' => 'Notification marked as UnRead successfully.','notificationId'=>$notification->id]);
            } else {
                $notification->update(['isRead' => true]);
                return response()->json(['message' => 'Notification marked as Read successfully.','notificationId'=>$notification->id]);
            }
            $notification->save();

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while updating read notification.'], 500);
        }
    }
    
    
}
