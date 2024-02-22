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
    public function addToFavorites(Recipe $recipe)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    
        // Retrieve the authenticated user
        $user = auth()->user();
    
        try {
            // Check if the recipe is already in the user's favorites
            if ($user->favorites()->where('recipe_id', $recipe->id)->exists()) {
                // Recipe is already in favorites, so remove it
                $user->favorites()->detach($recipe->id);
                return response()->json(['message' => 'Recipe removed from favorites.']);
            } else {
                // Recipe is not in favorites, so add it
                $user->favorites()->attach($recipe->id);
                return response()->json(['message' => 'Recipe added to favorites.']);
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            return response()->json(['message' => 'Error occurred while updating favorites.'], 500);
        }
    }


    public function index(Request $request, User $user)
    {
        if ($request->user()->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        try {
            $favorites = $user->favorites()->with('ingredients','user.images', 'steps','comments','images')->get();
    
            if ($favorites->isEmpty()) {
                return response()->json(['message' => 'No favorite recipes found.'], 404);
            }
    
            return response()->json(['data' => $favorites]);
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            return response()->json(['message' => 'Error occurred while fetching favorite recipes.'], 500);
        }
    }

}