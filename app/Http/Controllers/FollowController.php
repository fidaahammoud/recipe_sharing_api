<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;
use App\Models\Follow;

use Illuminate\Support\Facades\Log;


class FollowController extends Controller
{
    public function updateStatusFollow(Request $request, $follower_id, $followed_id){
        $follower = User::findOrFail($follower_id);
        $followed = User::findOrFail($followed_id);
    
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    
        if ($request->user()->id !== $follower->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        try {
            $follow = Follow::where('follower_id', $follower->id)
                        ->where('followed_id', $followed->id)
                        ->first(); 
            if ($follow) {
                if ($follow->isFollowed) { 
                    $follow->update(['isFollowed' => false]);
                    $followed->decrement('totalFollowers');
                    $totalFollowers = $followed->totalFollowers;
                    $message = 'You have unfollowed ' . $followed->name . ' successfully.';
                    return response()->json(['message' => $message, 'totalFollowers' => $totalFollowers]);
                } else {
                    $follow->update(['isFollowed' => true]);
                    $followed->increment('totalFollowers');
                    $totalFollowers = $followed->totalFollowers;
    
                    $notificationContent = 'User ' . $follower->name . ' started following you.';
                    $notification = new Notification([
                        'source_user_id' => $follower->id,
                        'destination_user_id' => $followed->id,
                        'content' => $notificationContent,
                    ]);
                    $notification->save();
    
                    $message = 'You have followed ' . $followed->name . ' successfully.';
                    return response()->json(['message' => $message, 'totalFollowers' => $totalFollowers]);
                }
                $follow->save();
    
            } else {
                Log::info("toto");
                $follow = new Follow([
                    'follower_id' => $follower->id,
                    'followed_id' => $followed->id
                ]);
                $follow->save();
                $followed->increment('totalFollowers');
                $totalFollowers = $followed->totalFollowers;
    
                $notificationContent = 'User ' . $follower->name . ' started following you.';
                $notification = new Notification([
                    'source_user_id' => $follower->id,
                    'destination_user_id' => $followed->id,
                    'content' => $notificationContent,
                ]);
                $notification->save();
    
                $message = 'You have followed ' . $followed->name . ' successfully.';
                return response()->json(['message' => $message, 'totalFollowers' => $totalFollowers]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while updating likes.'], 500);
        }
    }
    

   


public function getFollowings(Request $request)
{
    $user = $request->user(); 

    // Retrieve only the followed users where isFollowed is true
    $followings = $user->followings()
                        ->wherePivot('isFollowed', true)
                        ->with('recipes.images', 'recipes.ingredients', 'recipes.steps', 'recipes.category', 'images')
                        ->get();

    return response()->json($followings);
}




}