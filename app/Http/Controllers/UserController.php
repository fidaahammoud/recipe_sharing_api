<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Gate;
use App\Policies\UserPolicy;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\User; 
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Models\Notification;
use App\Models\Follow;

use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
       // $users = User::all();

       // return  $users;


       $users  = QueryBuilder::for(User::class)
        ->with('images')
        ->paginate();

       
        $value = env('URL_PAGINATE').'/users';

        $users->setPath($value);

      //  $users->setPath('http://192.168.56.10:80/laravel/api/users');

        
        return $users;
    }

    
    public function show(Request $request,  $user_id , $user_b_id)
    {
        $user = User::findOrFail($user_id);
        $user_b = User::findOrFail($user_b_id);

        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    
        if ($request->user()->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user_b->load('images');

        $follow = Follow::where('follower_id', $user->id)->where('followed_id', $user_b->id)->first();
        $isFollowed = $follow ? $follow->isFollowed : false;
        $user_b->isFollowed = $isFollowed;
       

        return  $user_b;
    }
    

public function updatePersonalInformation(Request $request, User $user)
{
    // Ensure the user is authenticated
    if (!Auth::check()) {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    // Check if the authenticated user matches the user whose profile is being updated
    if (Auth::id() !== $user->id) {
        return response()->json(['error' => 'Unauthorized access'], 403);
    }

    // Validate the request data
    $validator = Validator::make($request->all(), [
        'username' => 'sometimes|string|min:3|unique:users,username,' . $user->id,
        'name' => 'sometimes|string|max:255|min:3',
        'bio' => 'sometimes|nullable|string|max:255',
        'image_id' => 'sometimes|integer',
    ]);

  

    if ($validator->fails()) {
        $errors = $validator->errors()->toArray();
        $errorMessage = $validator->errors()->first();

        return response()->json([
            'message' => $errorMessage,
            'errors' => $errors,
        ], 422);
    }



    // Determine which attributes to update
    $attributesToUpdate = [];
    if ($request->filled('username')) {
        $attributesToUpdate['username'] = $request->input('username');
    }
    if ($request->filled('name')) {
        $attributesToUpdate['name'] = $request->input('name');
    }
    if ($request->filled('bio')) {
        $attributesToUpdate['bio'] = $request->input('bio');
    }
    if ($request->filled('image_id')) {
        $attributesToUpdate['image_id'] = $request->input('image_id');
    }

    // Update user's information
    $user->update($attributesToUpdate);

    // Refresh the user to get updated values
    $user->refresh();

    return response()->json([
        'message' => 'success',
        'user' => $user
    ]);
}

public function updateIsActiveNotification(Request $request, User $user)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        Log::Info($request);
        Log::Info($user);
        try {
            if ($user->isNotificationActive) { 
                $user->update(['isNotificationActive' => false]);
                return response()->json(['message' => 'Receive Notification is turned false.','isNotificationActive'=>$user->isNotificationActive]);
            } else {
                $user->update(['isNotificationActive' => true]);
                return response()->json(['message' => 'Receive Notification is turned true.','isNotificationActive'=>$user->isNotificationActive]);
            }
            $user->save();

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while updating read isNotificationActive.'], 500);
        }
    }
    



}