<?php

namespace App\Http\Controllers;

use Spatie\QueryBuilder\QueryBuilder;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Step;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Http\Resources\RecipeCollection;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Like;
use App\Models\Rating;

use Illuminate\Http\Request; 

class RecipeController extends Controller
{

    public function __construct()
{
    $this->authorizeResource(Recipe::class, 'recipe');
}

    public function index(Request $request)
    {
        $recipes = QueryBuilder::for(Recipe::class)
        ->allowedFilters(['category.name'])
        ->defaultSort('-created_at')
        ->allowedSorts(['preparationTime', 'created_at'])
        ->with('ingredients', 'steps')
        ->paginate();

    // Set the path for pagination links
    $recipes->setPath('http://157.241.61.249:80/laravel/api/recipes');

    // Return the paginated results using your RecipeCollection
    return RecipeResource::collection($recipes);
        
    }

    public function store(StoreRecipeRequest $request)
    {
    
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        
        $validatedData = $request->validated();
    
        // Create Category
        $category = Category::firstOrCreate(['name' => $validatedData['category']]);
        
        // Create Recipe
        $recipe = Auth::user()->recipes()->create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'category_id' => $category->id,
            'preparationTime' => $validatedData['preparationTime'],
        ]);
    
        // Create or find Ingredients
        $ingredientsData = $validatedData['ingredients'];
    
        foreach ($ingredientsData as $ingredientData) {
            $ingredient = new Ingredient([
                'ingredientName' => $ingredientData['ingredientName'],
                'measurementUnit' => $ingredientData['measurementUnit'],
            ]);
    
            $recipe->ingredients()->save($ingredient);
        }
    
        // Create Steps
        $stepsData = $validatedData['preparationSteps'];
    
        foreach ($stepsData as $stepData) {
            $step = new Step([
                'stepDescription' => $stepData,
            ]);
    
            $recipe->steps()->save($step);
        }
    
        // Eager load the relationships
        $recipe->load('category', 'ingredients', 'steps', 'user');
    
        return new RecipeResource($recipe);
    }
    

    public function show(Request $request, Recipe $recipe)
    {
        $recipe->load('ingredients', 'steps','comments'); // Eager load the relationships
        return new RecipeResource($recipe);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe)
{
    
     // Check if the authenticated user is the creator of the recipe
     if (Auth::id() !== $recipe->creator_id) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $validatedData = $request->validated();

    // Update the recipe's attributes
    $recipe->update($validatedData);

    // Update the category
    $category = Category::firstOrCreate(['name' => $validatedData['category']]);
    $recipe->category()->associate($category)->save();

    // Update or create ingredients
    $ingredientsData = $validatedData['ingredients'];
    $recipe->ingredients()->delete(); // Remove existing ingredients

    foreach ($ingredientsData as $ingredientData) {
        $ingredient = new Ingredient([
            'ingredientName' => $ingredientData['ingredientName'],
            'measurementUnit' => $ingredientData['measurementUnit'],
        ]);

        $recipe->ingredients()->save($ingredient);
    }

    // Update or create steps
    $stepsData = $validatedData['preparationSteps'];
    $recipe->steps()->delete(); // Remove existing steps

    foreach ($stepsData as $stepData) {
        $step = new Step([
            'stepDescription' => $stepData,
        ]);

        $recipe->steps()->save($step);
    }

    // Eager load the relationships
    $recipe->load('category', 'ingredients', 'steps', 'user');

    return new RecipeResource($recipe);
}


    public function destroy(Recipe $recipe)
    {
        // Check if the authenticated user is the creator of the recipe
        if (Auth::id() !== $recipe->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $recipe->delete();

        return response()->json(['message' => 'Recipe deleted successfully']);
    }

    public function categories()
    {
        return Category::all();
    }

    public function userRecipes(User $user)
{
    $recipes = $user->recipes;
    $recipes->load('ingredients', 'steps','comments'); // Eager load the relationships

    // Using the RecipeResource for each recipe in the collection
    $resource = RecipeResource::collection($recipes);

    return $resource;

    
}


    public function likeRecipe(Recipe $recipe)
    {
        // Ensure the user is authenticated
        $user = auth()->user();

        // Check if the user has already liked the recipe
        $like = $recipe->likes()->where('user_id', $user->id)->first();

        if (!$like) {
            // If not, create a new like
            $like = new Like(['user_id' => $user->id]);
            $recipe->likes()->save($like);

            // Increment the like count in the Recipe model
            $recipe->increment('totalLikes');

            return response()->json(['message' => 'Recipe liked successfully.']);
        } else {
            // If already liked, unlike it
            $like->delete();

            // Decrement the like count in the Recipe model
            $recipe->decrement('totalLikes');

            return response()->json(['message' => 'Recipe unliked successfully.']);
        }
    }

    public function rateRecipe(Recipe $recipe, $rating)
    {
        // Ensure the user is authenticated
        $user = auth()->user();
    
        // Check if the user has already rated the recipe
        $existingRating = $recipe->ratings()->where('user_id', $user->id)->first();
    
        if ($existingRating) {
            // If already rated, update the rating
            $existingRating->update(['rating' => $rating]);
        } else {
            // If not, create a new rating
            $ratingModel = new Rating(['user_id' => $user->id, 'rating' => $rating]);
            $recipe->ratings()->save($ratingModel);
        }
    
        // Calculate the new average rating
        $totalRatings = $recipe->ratings()->count();
        $sumRatings = $recipe->ratings()->sum('rating');
        $newAverageRating = $totalRatings > 0 ? $sumRatings / $totalRatings : 0;
    
        // Update the average rating in the Recipe model
        $recipe->avrgRating = $newAverageRating;
        $recipe->save();
    
        return response()->json(['message' => 'Recipe rated successfully.']);
    }
    



}
