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

class UserController extends Controller
{
    public function index(Request $request)
    {
       // $users = User::all();

       // return  $users;


       $users  = QueryBuilder::for(User::class)
        ->with('images')
        ->paginate();

        // Set the path for pagination links
        $users->setPath('http://192.168.56.10:80/laravel/api/users');

        // Return the paginated results using your RecipeCollection
        // return RecipeResource::collection($recipes);
        return $users;
    }

    
    public function show(Request $request, User $user)
    {
        if ($request->user()) {
            $authenticatedUserId = $request->user()->id;
        }

        $user->load('images');
        return  $user;
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
        $errors = $validator->errors()->all();
        return response()->json(['error' => 'Validation failed', 'message' => $errors], 400);
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
        'message' => 'Personal information updated successfully',
        'user' => $user
    ]);
}


    public function toggleFollow(Request $request, User $user)
    {
        $authenticatedUser = $request->user(); // Retrieve the authenticated user

        // Check if the authenticated user is already following the given user
        $isFollowing = $authenticatedUser->followings()->where('followed_id', $user->id)->exists();

        if ($isFollowing) {
            $authenticatedUser->followings()->detach($user->id);
            $user->decrement('totalFollowers'); 
            $message = 'You have unfollowed ' . $user->name;
        } else {
            $authenticatedUser->followings()->attach($user->id);
            $user->increment('totalFollowers'); 
            $message = 'You are now following ' . $user->name;

            // Create a notification for the followed user
            $notificationContent = 'User ' . $authenticatedUser->name . ' is now following you.';
            $notification = new Notification([
                'source_user_id' => $authenticatedUser->id,
                'destination_user_id' => $user->id,
                'content' => $notificationContent,
            ]);
            $notification->save();
        }

       // return response()->json(['message' => $message, $user->load('images')], Response::HTTP_OK);

        // Create the custom response array
    $responseData = [
        'message' => $message,
        'user' => $user->load('images') // Load the user's images
    ];

    // Return the custom response
    return response()->json($responseData, Response::HTTP_OK);
    }

    public function getFollowings(Request $request)
    {
        $user = $request->user(); 

        $followings = $user->followings()->with('recipes.images','recipes.ingredients','recipes.steps','recipes.category','images')->get();

        return response()->json($followings);
    }
}