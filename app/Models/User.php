<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Like;
use App\Models\Rating;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'profilePicture',
        'bio',
        'image_id',
        'isNotificationActive'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function images(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class, 'creator_id');
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'favorite')->withTimestamps();
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Like::class, 'like')->withTimestamps();
    }

    public function ratings(): BelongsToMany
    {
        return $this->belongsToMany(Rating::class, 'rate')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }
}
