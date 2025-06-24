<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class seller_requests extends Model
{
    protected $fillable = [
        'user_id',
        'store_name',
        'store_logo',
        'store_description',
        'stripe_account_id',
        'phone',
        'address',
        'status',
        'admin_feedback',
    ];
    protected $table = 'seller_requests';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
