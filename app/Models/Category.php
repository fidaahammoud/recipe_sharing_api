<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Recipe;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // If your table name is different from the default naming convention
    protected $table = 'categories';

    // If you don't want timestamps
    public $timestamps = false;

    // Relationships
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }
}
