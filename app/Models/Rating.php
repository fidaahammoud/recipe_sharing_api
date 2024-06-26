<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Recipe;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'recipe_id', 'rating','isRated'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recipe():BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
    
}
