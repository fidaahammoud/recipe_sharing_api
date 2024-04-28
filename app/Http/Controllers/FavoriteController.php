<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Favorite;
use App\Http\Resources\RecipeResource;

class FavoriteController extends Controller
{
   public function updateStatusFavorite(Request $request, User $user , Recipe $recipe)
{
    
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    if ($request->user()->id !== $user->id) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    try {
        $favorite = Favorite::where('user_id', $user->id)
                        ->where('recipe_id', $recipe->id)
                        ->first(); 
        Log::Info($favorite);

        if ($favorite) {
            if ($favorite->isFavorite) { 
                $favorite->update(['isFavorite' => false]);
                return response()->json(['message' => 'Recipe removed from favorites.']);
            } else {
                $favorite->update(['isFavorite' => true]);
                return response()->json(['message' => 'Recipe added to favorites.']);
            }
            $favorite->save();
        } else {
            $user->favorites()->attach($recipe->id);
            return response()->json(['message' => 'Recipe added to favorites.']);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error occurred while updating favorites.'], 500);
    }
}



public function index(Request $request, User $user)
{
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    if ($request->user()->id !== $user->id) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    try {
        $favorites = $user->favorites()->where('isFavorite', true)
                        ->with('ingredients','user.images', 'steps','comments.user.images','images','category')
                        ->get();

        if ($favorites->isEmpty()) {
            return response()->json(['message' => 'No favorite recipes found.','data' => $favorites]);
        }

        return response()->json(['data' => $favorites]);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error occurred while fetching favorite recipes.'], 500);
    }
}

}