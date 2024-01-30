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
        $this->middleware('auth', ['only' => ['logout']]);
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
    $validator = Validator::make($request->all(), [
        'username' => 'required|string|unique:users,username',
        'name' => 'required|string|max:255',
        'profilePicture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'bio' => 'nullable|string|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Update the user's profile information
    $user->update([
        'username' => $request->input('username'),
        'name' => $request->input('name'),
        'bio' => $request->input('bio'),
    ]);

    // Handle profile picture upload
    if ($request->hasFile('profilePicture')) {
        $picturePath = $request->file('profilePicture')->store('profilePicture', 'public');
        $user->update(['profilePicture' => $picturePath]);
    }

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