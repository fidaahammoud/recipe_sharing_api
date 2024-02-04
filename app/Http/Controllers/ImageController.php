<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function imageStore(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $image_path = $request->file('image')->store('image', 'public');

        $data = Image::create([
            'image' => $image_path,
        ]);

        return response($data, Response::HTTP_CREATED);
    }
}