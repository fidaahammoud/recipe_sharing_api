<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Comment;
use App\Http\Resources\CommentResource;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Recipe $recipe)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $comment = new Comment([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        $recipe->comments()->save($comment);

        //return new CommentResource($comment);
        return response()->json(['message' => 'Comment added successfully']);
    }
}
