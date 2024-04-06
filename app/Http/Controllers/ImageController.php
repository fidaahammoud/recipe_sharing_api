<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
//use Illuminate\Support\Facades\Response;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Support\Facades\Response as LaravelResponse;

use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Recipe;


class ImageController extends Controller
{

    use ApiResponse;

public function uploadImageMobile(Request $request, User $user)
{
    
    if (!Auth::user() || Auth::user()->id !== $user->id) {
        return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }

    $this->validate($request, [
        'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    ]);
    Log::info(time().'.'.$request->image);

    $imagePath = $request->file('image')->store('images', 'public');

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

// public function uploadImageWeb(Request $request,  User $user) {
//     if($request->hasFile("image")) {
//         $image = $request->file("image");
//         $imageName = time() . ".". $image->getClientOriginalExtension();
//         $image->move(public_path("/storage/images"), $imageName);

//         $image = Image::create([
//             'image' => $imageName,
//         ]);

//         return response()->json($this->apiResponse($imageName, "created", 200));
//     }
//     return response()->json($this->apiResponse(null,"",404));
// }

public function uploadImageWeb(Request $request,  User $user) {
    if ($request->hasFile("image")) {
        $image = $request->file("image");
        $imageName = time() . "." . $image->getClientOriginalExtension();
        
        $imagePath = "images/" . $imageName;
        
        $image->move(public_path("/storage/images"), $imageName);

        $imageModel = Image::create([
            'image' => $imagePath, 
        ]);

        return response()->json([
            'image_id' => $imageModel->id, 
            'image_name' => $imagePath,
            'status' => 'created',
        ], 200);
    }

    return response()->json([
        'error' => 'No image provided',
    ], 404);
}

}