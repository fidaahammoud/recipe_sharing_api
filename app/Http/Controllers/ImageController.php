<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Recipe;


class ImageController extends Controller
{
//     public function profileImageStore(Request $request, User $user)
// {
//     // Validate if the provided user matches the authenticated user
//     if (!Auth::user() || Auth::user()->id !== $user->id) {
//         return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
//     }

//     // Validate the image
//     $this->validate($request, [
//         'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
//     ]);

//     // Store the image
//     $imagePath = $request->file('image')->store('images', 'public');

//     // Create a new Image instance
//     $image = Image::create([
//         'image' => $imagePath,
//     ]);

//     // Associate the image with the user using the image_id column
//     $user->image_id = $image->id;
//     $user->save();

//     return response()->json($image, Response::HTTP_CREATED);
// }

public function recipeImageStore(Request $request, User $user)
{
    // Validate if the provided user matches the authenticated user
    if (!Auth::user() || Auth::user()->id !== $user->id) {
        return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }

    // Validate the image
    $this->validate($request, [
        'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    ]);

    // Store the image
    $imagePath = $request->file('image')->store('images', 'public');

    // Create a new Image instance
    $image = Image::create([
        'image' => $imagePath,
    ]);

     //Associate the image with the recipe using the image_id column
    //$recipe->image_id = $image->id;
    //$recipe->save();

    return response()->json($image, Response::HTTP_CREATED);
}


public function profileImageStore(Request $request, User $user)
{
    // Validate if the provided user matches the authenticated user
    if (!Auth::user() || Auth::user()->id !== $user->id) {
        return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }

    // Validate the image
    $this->validate($request, [
        'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    ]);

    // Store the image
    $imagePath = $request->file('image')->store('images', 'public');

    // Create a new Image instance
    $image = Image::create([
        'image' => $imagePath,
    ]);


    return response()->json($image, Response::HTTP_CREATED);
}


public function index()
{
    $images = Image::all();

    return response()->json(['data' => $images], Response::HTTP_OK);
}


public function show($id)
{
    $image = Image::find($id);

    if (!$image) {
        return response()->json(['error' => 'Image not found'], Response::HTTP_NOT_FOUND);
    }

    return response()->json(['data' => $image], Response::HTTP_OK);
}
}