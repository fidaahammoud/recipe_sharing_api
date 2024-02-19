<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Gate;
use App\Policies\UserPolicy;

use App\Models\User; 
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();

        return new UserCollection($users);
    }

    
    public function show(Request $request, User $user)
    {
        if ($request->user()) {
            $authenticatedUserId = $request->user()->id;
        }
        return new UserResource($user);
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
            'username' => 'sometimes|string|unique:users,username,' . $user->id,
            'name' => 'sometimes|string|max:255',
            'bio' => 'sometimes|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed', 'messages' => $validator->errors()], 400);
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
    
        // Update user's basic information
        $user->update($attributesToUpdate);
    
        return response()->json([
            'message' => 'Personal information updated successfully',
            'user' => $user,
        ]);
    }
    
    
}