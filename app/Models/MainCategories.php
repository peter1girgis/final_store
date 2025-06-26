<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategories extends Model
{
    use HasFactory;
    protected $fillable = ['name','image',];
    public function categories()
{
    return $this->hasMany(categories::class, 'main_category_id');
}

}
