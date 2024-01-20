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
        $recipe->load('ingredients', 'steps'); // Eager load the relationships
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
    $recipe->update([
        'title' => $validatedData['title'],
        'description' => $validatedData['description'],
        'preparationTime' => $validatedData['preparationTime'],
    ]);

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
    $recipes->load('ingredients', 'steps'); // Eager load the relationships

    // Using the RecipeResource for each recipe in the collection
    $resource = RecipeResource::collection($recipes);

    return $resource;

    
}

}
