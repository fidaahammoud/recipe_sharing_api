<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User; 

class Image extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'image'
    ];


   
}
