<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    protected $fillable = [
        'user_id',
        'number',
        'amount',
        'round_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}