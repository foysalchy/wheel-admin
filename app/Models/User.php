<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'username',
        'name',
        'password',
        'wallet',
        'email',
        'phone',
        'photo',
        'status',
        'is_promoter',
        'is_vip',
    ];

    protected $hidden = [
        'password'
    ];

    public function bets()
    {
        return $this->hasMany(Bet::class);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }
}