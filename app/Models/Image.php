<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Recipe;
use App\Models\User;


class Image extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'image'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }
   
}
