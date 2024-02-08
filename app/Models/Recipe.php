<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'category_id', 'description', 'imageUrl', 'preparationTime', 'comment','totalLikes','avrgRating',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class);
    }

    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'recipe_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
   

    

    
}
