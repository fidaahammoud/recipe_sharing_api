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
    
        $validator = Validator::make($request->all(), [
            'username' => 'sometimes|string|min:3|unique:users,username,' . $user->id,
            'name' => 'sometimes|string|max:255|min:3',
            'bio' => 'sometimes|nullable|string|max:255',
        ]);
    
        if ($validator->fails()) {
            //return response()->json(['error' => 'Validation failed', 'message' => $validator->errors()], 400);
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
        $attributesToUpdate['bio'] = $request->filled('bio') ? $request->input('bio') : null;
    
        // Update user's basic information
        $user->update($attributesToUpdate);
    
        return response()->json([
            'message' => 'Personal information updated successfully',
            'user' => $user,
            
        ]);
    }
    
    public function toggleFollow(Request $request, User $user)
{
    $authenticatedUser = $request->user(); // Retrieve the authenticated user

    // Check if the authenticated user is already following the given user
    $isFollowing = $authenticatedUser->followings()->where('followed_id', $user->id)->exists();

    if ($isFollowing) {
        $authenticatedUser->followings()->detach($user->id);
        $message = 'You have unfollowed ' . $user->name;
    } else {
        $authenticatedUser->followings()->attach($user->id);
        $message = 'You are now following ' . $user->name;
    }

    return response()->json(['message' => $message], Response::HTTP_OK);
}

    public function getFollowings(Request $request)
    {
        $user = $request->user(); 

        $followings = $user->followings()->with('recipes.images','recipes.ingredients','recipes.steps','recipes.category','images')->get();

        return response()->json($followings);
    }
}