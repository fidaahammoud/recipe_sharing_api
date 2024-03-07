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
use Illuminate\Database\Eloquent\Builder;

class RecipeController extends Controller
{

    public function index(Request $request)
    {
        $recipes = QueryBuilder::for(Recipe::class)
        ->allowedFilters(['category.name'])
        ->defaultSort('-created_at')
        ->allowedSorts(['preparationTime', 'created_at','totalLikes','avrgRating'])
        ->with('ingredients','user.images', 'steps','comments.user.images','images','category')
        ->paginate();

        // Set the path for pagination links
        $recipes->setPath('http://192.168.56.10:80/laravel/api/recipes');

        // Return the paginated results using your RecipeCollection
        // return RecipeResource::collection($recipes);
        return $recipes;
    }

    public function store(StoreRecipeRequest $request)
    {
    
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        
        $validatedData = $request->validated();
    
    
        // Create Recipe
        $recipe = Auth::user()->recipes()->create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'comment' => $validatedData['comment'],
            'category_id' =>  $validatedData['category_id'],
            'preparationTime' => $validatedData['preparationTime'],
            'image_id' => $validatedData['image_id'],
            
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
        $recipe->load('category', 'ingredients', 'steps', 'user','comments.user.images','images');
        return $recipe;
    }
    

    public function show(Request $request, Recipe $recipe)
    {
        $recipe->load('user.images','ingredients', 'steps','comments.user.images','images','category');
        return $recipe;
    }

    public function update(Request $request, Recipe $recipe)
    {
        // Check if the authenticated user is the creator of the recipe
        if (Auth::id() !== $recipe->creator_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        // Get the validated data from the request
        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'preparationTime' => 'sometimes|integer',
            'category_id' => 'sometimes|integer',
            'ingredients' => 'sometimes|array',
            'ingredients.*.ingredientName' => 'sometimes|string',
            'ingredients.*.measurementUnit' => 'sometimes|string',
            'preparationSteps' => 'sometimes|array',
            'preparationSteps.*' => 'sometimes|string',
            'image_id' => 'sometimes|integer',
            'comment' => 'sometimes|string',

        ]);
    
        // Update Recipe with only the provided fields
        $recipe->update($validatedData);
    
        // Update or create Ingredients
        if (isset($validatedData['ingredients'])) {
            $recipe->ingredients()->delete(); // Remove existing ingredients
    
            foreach ($validatedData['ingredients'] as $ingredientData) {
                $recipe->ingredients()->create($ingredientData);
            }
        }
    
        // Update Steps
        if (isset($validatedData['preparationSteps'])) {
            $recipe->steps()->delete(); // Remove existing steps
    
            foreach ($validatedData['preparationSteps'] as $stepData) {
                $recipe->steps()->create(['stepDescription' => $stepData]);
            }
        }
    
        // Eager load the relationships
        $recipe->load('category', 'ingredients', 'steps', 'user', 'comments.user.images');
    
        return $recipe;
    }
    
    

    public function destroy(Recipe $recipe)
    {
        // Check if the authenticated user is the creator of the recipe
        if (Auth::id() !== $recipe->creator_id) {
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
    $recipes->load('ingredients','user.images', 'steps','comments.user.images','images','category'); 

    return  [
        'data' => $recipes 
    ];

    
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

            $nbOfLikes = $recipe->totalLikes;

            return response()->json(['message' => 'Recipe liked successfully.', 'nbOfLikes' => $nbOfLikes]);
        } else {
            // If already liked, unlike it
            $like->delete();

            // Decrement the like count in the Recipe model
            $recipe->decrement('totalLikes');
            $nbOfLikes = $recipe->totalLikes;

            return response()->json(['message' => 'Recipe unliked successfully.','nbOfLikes' => $nbOfLikes]);
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
    
        // Return the response with average rating included
        return response()->json(['message' => 'Recipe rated successfully.', 'avgRating' => $newAverageRating]);
    }


    
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
        ]);
    
        $searchQuery = $request->input('query');
    
        $results = Recipe::where('title', 'like', "%$searchQuery%")
                         ->orWhere('description', 'like', "%$searchQuery%")
                         ->orWhere('preparationTime', 'like', "%$searchQuery%")
                         ->orWhereHas('ingredients', function ($query) use ($searchQuery) {
                             $query->where('ingredientName', 'like', "%$searchQuery%")
                                    ->orWhere('measurementUnit', 'like', "%$searchQuery%");

                         })
                         ->orWhereHas('user', function ($query) use ($searchQuery) {
                             $query->where('name', 'like', "%$searchQuery%")
                                   ->orWhere('username', 'like', "%$searchQuery%");
                         })
                         ->orWhereHas('category', function ($query) use ($searchQuery) {
                             $query->where('name', 'like', "%$searchQuery%");
                         })
                         ->get();
        $results->load('ingredients','user.images', 'steps','comments.user.images','images','category');
        

        return  [
            'data' => $results
        ];
    }
    
    
    
    
    
    
    
}
