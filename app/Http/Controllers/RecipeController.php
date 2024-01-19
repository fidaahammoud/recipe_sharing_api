<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Category;

class RecipeController extends Controller
{
    public function index()
    {
        return Recipe::with(['category', 'steps', 'ingredients'])->get();
    }

    public function store(Request $request)
    {
        $recipeData = $request->input('recipe');

        if (!$recipeData) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        $category = Category::firstOrCreate(['name' => $recipeData['category']]);
        $recipe = $category->recipes()->create([
            'title' => $recipeData['title'],
            'preference' => $recipeData['preference'],
            'description' => $recipeData['description'],
            'imageUrl' => $recipeData['imageUrl'],
            'preparationTime' => $recipeData['preparationTime'],
            'comments' => $recipeData['comments'],
        ]);

        // Add steps to the recipe
        $recipe->steps()->createMany($recipeData['steps']);

        // Add ingredients to the recipe
        $recipe->ingredients()->createMany($recipeData['ingredients']);

        return response()->json($recipe->load(['category', 'steps', 'ingredients']), 201);
    }

    public function show(Recipe $recipe)
    {
        return $recipe->load(['category', 'steps', 'ingredients']);
    }

    public function update(Request $request, Recipe $recipe)
    {
       $recipeData = $request->input('recipe');

    if (!$recipeData) {
        return response()->json(['error' => 'Invalid payload'], 400);
    }

        $category = Category::firstOrCreate(['name' => $recipeData['category']]);
        
        $recipe->update([
            'title' => $recipeData['title'],
            'preference' => $recipeData['preference'],
            'description' => $recipeData['description'],
            'imageUrl' => $recipeData['imageUrl'],
            'preparationTime' => $recipeData['preparationTime'],
            'comments' => $recipeData['comments'],
            'category_id' => $category->id,
        ]);

        // Update steps
        $recipe->steps()->delete();
        $recipe->steps()->createMany($recipeData['steps']);

        // Update ingredients
        $recipe->ingredients()->delete();
        $recipe->ingredients()->createMany($recipeData['ingredients']);

        return response()->json($recipe->load(['category', 'steps', 'ingredients']), 200);
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->steps()->delete();
        $recipe->ingredients()->delete();
        $recipe->delete();
        return response()->json(null, 204);
    }

    public function categories()
    {
        return Category::all();
    }
}
