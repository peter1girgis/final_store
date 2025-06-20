<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'status',
        'related_id',
        'related_type',
    ];
    protected $table = 'notification';

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
