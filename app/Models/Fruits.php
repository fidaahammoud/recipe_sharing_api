<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Fruits extends Model
{
    protected $table = 'Fruits';
    protected $fillable = [
        'name',
        'color',
        'origin'
    ];
}
