<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function __construct()
{
    $this->middleware('auth', ['only' => ['logout', 'completeProfile']]);
}

    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(! Auth::attempt($validated)){
            return response()->json([
                'message' => 'Login information invalid',
            ], 401);
        }  

        $user = User::where('email', $validated['email'])->first();
        
        return response()->json([
            'access_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|max:255|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]); 

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        return response()->json([
            'data' => $user,
            'access_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer',
        ],201);
    }
 

    public function completeProfile(Request $request, User $user)
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
            'username' => 'required|string|unique:users,username,' . $user->id,
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed', 'messages' => $validator->errors()], 400);
        }
    
        // Update user's basic information
        $user->update([
            'username' => $request->input('username'),
            'name' => $request->input('name'),
            'bio' => $request->input('bio'),
        ]);
    
        return response()->json([
            'message' => 'Profile completed successfully',
            'user' => $user,
        ]);
    }
    



    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

  

}