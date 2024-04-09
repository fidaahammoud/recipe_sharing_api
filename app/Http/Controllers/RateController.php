<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Rating;
use App\Models\Notification;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\RecipeResource;

class RateController extends Controller
{
    //
    public function updateStatusRate(Request $request, User $user, Recipe $recipe, $rate)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if ($request->user()->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $rating = Rating::where('user_id', $user->id)
                ->where('recipe_id', $recipe->id)
                ->first();

            if ($rating) {
                if($rate == 0){
                    $rating->update(['isRated' => false]);
                }
                else{
                    $rating->update(['isRated' => true]);
                }

                $rating->update(['rating' => $rate]);

                $averageRating = Rating::where('recipe_id', $recipe->id)
                                ->where('isRated', true)
                                ->avg('rating');

                $recipe->avrgRating = $averageRating;
                $recipe->save();

                $notificationContent = 'User ' . $user->name . ' rated you recipe .' . $recipe->title . ' '.$rate;
                $notification = new Notification([
                    'source_user_id' => $user->id,
                    'destination_user_id' => $recipe->creator_id,
                    'content' => $notificationContent,
                ]);
                $notification->save();


                return response()->json(['message' => 'Recipe rated successfully.','avgRating' => $averageRating]);
                
            } else {
                $rating = new Rating([
                    'user_id' => $user->id,
                    'recipe_id' => $recipe->id,
                    'rating' => $rate,
                    'isRated' => true 
                ]);
                $rating->save();
                
                $averageRating = Rating::where('recipe_id', $recipe->id)
                    ->where('isRated', true)
                    ->avg('rating');

                $recipe->avrgRating = $averageRating;
                $recipe->save();

                $notificationContent = 'User ' . $user->name . ' rated you recipe .' . $recipe->title . ' '.$rate;
                $notification = new Notification([
                    'source_user_id' => $user->id,
                    'destination_user_id' => $recipe->creator_id,
                    'content' => $notificationContent,
                ]);
                $notification->save();
                
                return response()->json(['message' => 'Recipe rated successfully.','avgRating' => $averageRating]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while updating rating: ' . $e->getMessage()], 500);
        }
    }
}
