<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Fruits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FruitsController extends Controller
{

    public function __construct()
{
    // $this->middleware('auth', ['only' => ['logout', 'completeProfile']]);
}


    public function fruits(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'color' => 'required',
            'origin' => 'required',
        ]); 

        $fruits = Fruits::create($validated);
        return response()->json([
            'data' => $fruits,
        ],201);
    }
}