<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;

use App\Http\Controllers\ImageController;
use App\Http\Controllers\NotificationController;

use App\Http\Controllers\DietaryController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);


Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);

Route::get('dietaries', [DietaryController::class, 'index']);
Route::get('dietaries/{dietary}', [DietaryController::class, 'show']);


Route::get('users', [UserController::class, 'index']);
Route::get('users/{user}', [UserController::class, 'show']);

Route::get('users/{user}/recipes', [RecipeController::class, 'userRecipes']);

Route::post('recipes/search', [RecipeController::class, 'search']);

Route::get('recipes', [RecipeController::class, 'index']);

Route::get('images', [ImageController::class, 'index']);
Route::get('images/{id}', [ImageController::class, 'show']);




Route::middleware('auth:sanctum')->group(function (){
    Route::post('recipes', [RecipeController::class, 'store']);
    Route::put('recipes/{recipe}', [RecipeController::class, 'update']);
    Route::delete('recipes/delete/{recipe}', [RecipeController::class, 'destroy']);

    Route::post('recipes/{recipe}/comments', [CommentController::class, 'store']);
  
    Route::post('recipes/{recipe}/like', [RecipeController::class, 'likeRecipe']);
    Route::post('recipes/{recipe}/rate/{rating}', [RecipeController::class, 'rateRecipe']);


    Route::put('completeProfile/{user}', [AuthController::class, 'completeProfile']);


    Route::post('{user}/{recipe}/updateStatusFavorite', [FavoriteController::class, 'updateStatusFavorite']);
    Route::get('users/{user}/favorites', [FavoriteController::class, 'index']);

    Route::post('users/{user}/toggleFollow', [UserController::class, 'toggleFollow']);
    Route::get('users/{user}/followings',  [UserController::class, 'getFollowings']);

    Route::get('notifications',  [NotificationController::class, 'getNotifications']);


    Route::put('updatePersonalInformation/{user}', [UserController::class, 'updatePersonalInformation']);

    Route::post('image/{user}', [ImageController::class, 'uploadImageMobile']);

    Route::post('uploadImageWeb/{user}', [ImageController::class, "uploadImageWeb"]);

    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('{user}/recipes/{recipe}', [RecipeController::class, 'show']);

});