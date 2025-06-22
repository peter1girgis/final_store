<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'name',
        'description',
        'price',
        'old_price',
        'main_image',
        'sub_images',
        'stock',
    ];

    // التعامل مع الصور الفرعية كـ array
    protected $casts = [
        'sub_images' => 'array',
    ];
    protected $table = 'products';
    public function store()
    {
        return $this->belongsTo(stores::class);
    }
    public function categories()
    {

        return $this->belongsToMany(categories::class, 'category_product', 'product_id', 'category_id');

    }
    // app/Models/Product.php

    protected static function booted()
    {
        static::deleting(function ($product) {
            $product->categories()->detach();
        });
    }

}
