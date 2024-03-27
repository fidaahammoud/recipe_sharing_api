<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Dietary;

class DietaryController extends Controller
{
    public function index(Request $request)
    {
        $dietary = Dietary::all();

        return  $dietary;
    }

    public function show(Dietary $dietary)
    {
        $dietary->load('recipes.user.images','recipes.images','recipes.category');

        return $dietary;
    }
}
