<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'method',
        'account_number',
        'trx_id',
        'screenshot',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}