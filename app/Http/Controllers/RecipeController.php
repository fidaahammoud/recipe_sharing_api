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
use App\Models\Favorite;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request; 
use Illuminate\Database\Eloquent\Builder;
use App\Models\Notification;
class RecipeController extends Controller
{

    public function index(Request $request)
    {
        $recipes = QueryBuilder::for(Recipe::class)
        ->allowedFilters(['category.name','dietary.name'])
        ->defaultSort('-created_at')
        ->allowedSorts(['preparationTime', 'created_at','totalLikes','avrgRating'])
        ->with('ingredients','user.images', 'steps','comments.user.images','images','category','dietary')
        ->paginate();

        $recipes->setPath('http://192.168.56.10:80/laravel/api/recipes');

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
            'dietary_id' =>  $validatedData['dietary_id'],
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
        $recipe->load('category','dietary', 'ingredients', 'steps', 'user','comments.user.images','images');
       // return $recipe;

        return response()->json(['message' => 'success', 'recipe' => $recipe]);
    }
    

    public function show(Request $request, User $user , Recipe $recipe)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    
        if ($request->user()->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $recipe->load('user.images','ingredients', 'steps','comments.user.images','images','category','dietary');
        
        $favorite = Favorite::where('user_id', $user->id)->where('recipe_id', $recipe->id)->first();
        $isFavorite = $favorite ? $favorite->isFavorite : false;
        $recipe->isFavorite = $isFavorite;

        $like = Like::where('user_id', $user->id)->where('recipe_id', $recipe->id)->first();
        $isLiked = $like ? $like->isLiked : false;
        $recipe->isLiked = $isLiked;


        $rate = Rating::where('user_id', $user->id)->where('recipe_id', $recipe->id)->first();
        $isRated = $rate ? $rate->isRated : false;
        $recipe->isRated = $isRated;
       
        $rating = $rate ? $rate->rating : null;
        $recipe->rating = $rating;


        return $recipe;
    }


    public function update(Request $request, Recipe $recipe)
    {
        // Check if the authenticated user is the creator of the recipe
        if (Auth::id() !== $recipe->creator_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        // Get the validated data from the request
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255|min:3',
            'description' => 'sometimes|string|min:3|max:1000',
            'preparationTime' => 'sometimes|integer',
            'category_id' => 'sometimes|integer',
            'dietary_id' => 'sometimes|integer',
            'ingredients' => 'sometimes|array',
            'ingredients.*.ingredientName' => 'sometimes|string',
            'ingredients.*.measurementUnit' => 'sometimes|string',
            'preparationSteps' => 'sometimes|array',
            'preparationSteps.*' => 'sometimes|string',
            'image_id' => 'sometimes|integer',
            'comment' => 'sometimes|nullable|string',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            $errorMessage = $validator->errors()->first();
    
            return response()->json([
                'message' => $errorMessage,
                'errors' => $errors,
            ], 422);
        }
    
        // Update Recipe with only the provided fields and set isActive to false
        $recipe->update(array_merge($validator->validated(), ['isActive' => false]));
    
        // Update or create Ingredients
        if ($request->has('ingredients')) {
            $recipe->ingredients()->delete(); // Remove existing ingredients
    
            foreach ($request->input('ingredients') as $ingredientData) {
                $recipe->ingredients()->create($ingredientData);
            }
        }
    
        // Update Steps
        if ($request->has('preparationSteps')) {
            $recipe->steps()->delete(); // Remove existing steps
    
            foreach ($request->input('preparationSteps') as $stepData) {
                $recipe->steps()->create(['stepDescription' => $stepData]);
            }
        }
    
        // Eager load the relationships
        $recipe->load('category', 'dietary', 'ingredients', 'steps', 'user', 'comments.user.images');
    
        return response()->json(['message' => 'success', 'recipe' => $recipe]);
    }
    




//     public function update(Request $request, Recipe $recipe)
// {
//     // Check if the authenticated user is the creator of the recipe
//     if (Auth::id() !== $recipe->creator_id) {
//         return response()->json(['message' => 'Unauthorized'], 403);
//     }

//     // Get the validated data from the request
//     $validator = Validator::make($request->all(), [
//         'title' => 'sometimes|string|max:255|min:3',
//         'description' => 'sometimes|string|min:3|max:1000',
//         'preparationTime' => 'sometimes|integer',
//         'category_id' => 'sometimes|integer',
//         'dietary_id' => 'sometimes|integer',
//         'ingredients' => 'sometimes|array',
//         'ingredients.*.ingredientName' => 'sometimes|string',
//         'ingredients.*.measurementUnit' => 'sometimes|string',
//         'preparationSteps' => 'sometimes|array',
//         'preparationSteps.*' => 'sometimes|string',
//         'image_id' => 'sometimes|integer',
//         'comment' => 'sometimes|nullable|string',
//     ]);

//     if ($validator->fails()) {
//         $errors = $validator->errors()->all();
//         return response()->json(['error' => 'Validation failed', 'message' => $errors], 400);
//     }

//     // Update Recipe with only the provided fields
//     $recipe->update($validator->validated());

//     // Update or create Ingredients
//     if ($request->has('ingredients')) {
//         $recipe->ingredients()->delete(); // Remove existing ingredients

//         foreach ($request->input('ingredients') as $ingredientData) {
//             $recipe->ingredients()->create($ingredientData);
//         }
//     }

//     // Update Steps
//     if ($request->has('preparationSteps')) {
//         $recipe->steps()->delete(); // Remove existing steps

//         foreach ($request->input('preparationSteps') as $stepData) {
//             $recipe->steps()->create(['stepDescription' => $stepData]);
//         }
//     }

//     // Eager load the relationships
//     $recipe->load('category', 'dietary', 'ingredients', 'steps', 'user', 'comments.user.images');

//     return $recipe;
// }

    

    public function destroy(Recipe $recipe)
    {
        // Check if the authenticated user is the creator of the recipe
        if (Auth::id() !== $recipe->creator_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $recipe->delete();

        return response()->json(['message' => 'success']);
    }


    public function categories()
    {
        return Category::all();
    }


    public function userRecipes(User $user)
{
    $recipes = $user->recipes()->orderBy('created_at', 'desc')->get();
    $recipes->load('ingredients','user.images', 'steps','comments.user.images','images','category','dietary'); 

    return  [
        'data' => $recipes 
    ];

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
                         ->orWhereHas('dietary', function ($query) use ($searchQuery) {
                            $query->where('name', 'like', "%$searchQuery%");
                        })
                         ->get();
        $results->load('ingredients','user.images', 'steps','comments.user.images','images','category');
        

        return  [
            'data' => $results
        ];
    }
    
    
    
    
    
    
    
}
