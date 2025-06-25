<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'user_state',
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
    public function evaluations()
    {
        return $this->hasMany(evaluations::class);
    }

    public function comments()
    {
        return $this->hasMany(comments::class);
    }
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }


    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function store()
    {
        return $this->hasOne(stores::class);
    }
    public function cartItems()
    {
        return $this->hasMany(\App\Models\CartItem::class);
    }
}
