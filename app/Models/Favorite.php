<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Recipe;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorite';

    
    protected $fillable = ['user_id', 'recipe_id','isFavorite'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recipe():BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

   
}
