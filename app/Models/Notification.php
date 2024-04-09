<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_user_id',
        'destination_user_id',
        'content',
        'isRead',
    ];

    public function sourceUser()
    {
        return $this->belongsTo(User::class, 'source_user_id');
    }

    public function destinationUser()
    {
        return $this->belongsTo(User::class, 'destination_user_id');
    }
}
