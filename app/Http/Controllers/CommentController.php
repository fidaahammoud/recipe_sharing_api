<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Comment;
use App\Http\Resources\CommentResource;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Recipe $recipe)
    {
        $comment = new Comment([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);

        $recipe->comments()->save($comment);

        return new CommentResource($comment);
    }
}
