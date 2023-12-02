<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Session extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'api_token'
    ];
}
