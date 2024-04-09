<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Category;
use App\Models\Dietary;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Image;
use App\Models\User;


class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'category_id', 'dietary_id','description', 'preparationTime', 'comment','totalLikes','avrgRating','image_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function dietary(): BelongsTo
    {
        return $this->belongsTo(Dietary::class, 'dietary_id');
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
        return $this->hasMany(Comment::class);
    }

    public function images()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    // public function likes(): HasMany
    // {
    //     return $this->hasMany(Like::class);
    // }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Like::class)->withTimestamps();
    }

    public function ratings(): BelongsToMany
    {
        return $this->belongsToMany(Rating::class)->withTimestamps();
    }

    // public function ratings(): HasMany
    // {
    //     return $this->hasMany(Rating::class);
    // }
   
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
    

    
}
