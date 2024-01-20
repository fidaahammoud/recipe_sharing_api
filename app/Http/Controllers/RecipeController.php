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

use Illuminate\Http\Request; 

class RecipeController extends Controller
{
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
        $validatedData = $request->validated();
    
        // Create Category
        $category = Category::firstOrCreate(['name' => $validatedData['category']]);
        
        // Create Recipe
        $recipe = Recipe::create([
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
    
        return new RecipeResource($recipe);
    }
    

    public function show(Request $request, Recipe $recipe)
    {
        $recipe->load('ingredients', 'steps'); // Eager load the relationships
        return new RecipeResource($recipe);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $validatedData = $request->validated();

        // If the category is present in the request, update it
        if (isset($validatedData['category'])) {
            $category = Category::firstOrCreate(['name' => $validatedData['category']]);
            $recipe->category()->associate($category);
        }
    
        // Update other attributes
        $recipe->update($validatedData);
    
        return new RecipeResource($recipe);
    }


    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return response()->json(['message' => 'Recipe deleted successfully']);
    }

    public function categories()
    {
        return Category::all();
    }

}
