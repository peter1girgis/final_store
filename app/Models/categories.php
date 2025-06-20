<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    protected $fillable = ['name'];
    protected $table = 'catagories';

    public function stores()
    {
        return $this->belongsToMany(stores::class, 'category_store');
    }
}
