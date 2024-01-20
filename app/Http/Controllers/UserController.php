<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\UserResource;
use App\Models\User; 
use App\Http\Resources\UserCollection;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return new UserCollection($users);
    }
}
