<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $fillable = [
        'roundid',
        'status',
        'result',
        'ended_at'
    ];
}