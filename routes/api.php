<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\IngredientController;

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


Route::post('recipes', [RecipeController::class, 'store']);
Route::get('recipes', [RecipeController::class, 'index']);
Route::get('recipes/{recipe}', [RecipeController::class, 'show']);

//Route::get('recipes/categories', [RecipeController::class, 'categories']);

Route::prefix('recipes')->group(function () {
    Route::put('/{recipe}', [RecipeController::class, 'update']);
    Route::delete('/{recipe}', [RecipeController::class, 'destroy']);
});


Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);
//Route::get('categories/{category}/recipes', [RecipeController::class, 'show']);



//Route::apiResource('steps', StepController::class);
//Route::apiResource('ingredients', IngredientController::class);
