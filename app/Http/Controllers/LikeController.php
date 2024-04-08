<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Like;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Favorite;
use App\Http\Resources\RecipeResource;

class LikeController extends Controller
{
    public function updateStatusLike(Request $request, User $user, Recipe $recipe)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if ($request->user()->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $like = Like::where('user_id', $user->id)
                        ->where('recipe_id', $recipe->id)
                        ->first(); 
            if ($like) {
                if ($like->isLiked) { 
                    $like->update(['isLiked' => false]);
                    $recipe->decrement('totalLikes');
                    $nbOfLikes = $recipe->totalLikes;
                    return response()->json(['message' => 'Recipe unliked successfully.','nbOfLikes' => $nbOfLikes]);
                } else {
                    $like->update(['isLiked' => true]);
                    $recipe->increment('totalLikes');
                    $nbOfLikes = $recipe->totalLikes;
                    return response()->json(['message' => 'Recipe liked successfully.','nbOfLikes' => $nbOfLikes]);
                }
                $like->save();

            } else {
                Log::info("toto");
                $like = new Like([
                    'user_id' => $user->id,
                    'recipe_id' => $recipe->id
                ]);
                $like->save();
                $recipe->increment('totalLikes');
                $nbOfLikes = $recipe->totalLikes;
                return response()->json(['message' => 'Recipe liked successfully.','nbOfLikes' => $nbOfLikes]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while updating likes.'], 500);
        }
    }


}