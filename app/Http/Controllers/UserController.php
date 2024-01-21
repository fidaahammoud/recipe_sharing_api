<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\UserResource;
use App\Models\User; 
use App\Http\Resources\UserCollection;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();

        return new UserCollection($users);
    }

    
    public function show(Request $request, User $user)
    {
        // You can access information from the request, if needed
        $authenticatedUserId = $request->user()->id;

        // You can directly use the $user model, which is automatically resolved by Laravel
        return new UserResource($user);
    }
    
}
