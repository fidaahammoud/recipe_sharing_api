<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Comment;
use App\Http\Resources\CommentResource;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification; 


class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Recipe $recipe)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $comment = new Comment([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        $recipe->comments()->save($comment);
        $recipe->load('comments.user.images');

        $notificationContent = 'User ' . Auth::user()->name . ' commented on your recipe "' . $recipe->title . '": ' . $comment->content;
        $notification = new Notification([
            'source_user_id' => Auth::id(),
            'destination_user_id' => $recipe->creator_id,
            'content' => $notificationContent,
        ]);
        $notification->save();

        return response()->json(['message' => 'Comment added successfully','data' =>  $recipe]);
    }
}
