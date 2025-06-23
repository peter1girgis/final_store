<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'store_id',
        'payment_id',
        'product_names',
        'total_quantity',
        'amount',
        'currency',
        'payment_status',
        'stripe_store_account_id',
    ];
}
