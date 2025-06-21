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
    protected $table = 'stores';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'store_id');
    }


    public function categories()
    {
        return $this->belongsToMany(categories::class, 'category_store');
    }
}
