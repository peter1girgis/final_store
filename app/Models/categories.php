<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    protected $fillable = ['name','image'];
    protected $table = 'categories';

    public function stores()
    {
        return $this->belongsToMany(stores::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
