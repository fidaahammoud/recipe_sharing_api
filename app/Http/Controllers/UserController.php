<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Gate;
use App\Policies\UserPolicy;

use App\Models\User; 
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UpdateUserRequest;
class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();

        return new UserCollection($users);
    }

    
    public function show(Request $request, User $user)
    {
        // access information from the request, if needed
        $authenticatedUserId = $request->user()->id;

        
        return new UserResource($user);
    }
    
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        // Ensure the authenticated user is the same as the user being updated
        if ($request->user()->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }
    
        // Update user information based on the validated data
        $user->update($request->validated());
    
        // Handle profile picture update if provided
        if ($request->hasFile('profilePicture')) {
            $profilePicturePath = $request->file('profilePicture')->store('profile_pictures', 'public');
            $user->profilePicture = $profilePicturePath;
            $user->save();
        }
    
        return response()->json([
            'message' => 'User information updated successfully.',
            'data' => new UserResource($user),
        ]);
    } 

}