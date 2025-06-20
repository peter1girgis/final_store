<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class stores extends Model
{
    protected $fillable = [
        'user_id',
        'store_name',
        'store_logo',
        'store_description',
        'phone',
        'address',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(categories::class, 'category_store');
    }
}
