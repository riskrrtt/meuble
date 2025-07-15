<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'total', 'status', 'items', 'cancel_requested',
    ];
    protected $casts = [
        'items' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
