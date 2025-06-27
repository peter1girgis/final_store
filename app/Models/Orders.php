<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_id',
        'products',
        'total_quantity',
        'state_of_order',
        'state_of_payment',
        'user_address',
        'user_phone_number',
        'user_email',
    ];

    protected $casts = [
        'product_ids' => 'array',
        'quantities' => 'array',
    ];

    public function store()
    {
        return $this->belongsTo(stores::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
