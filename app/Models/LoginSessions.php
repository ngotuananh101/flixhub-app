<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginSessions extends Model
{
    protected $fillable = [
        'user_id',
        'ip',
        'browser',
        'platform',
        'status',
    ];
}
