<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Initiative extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "id_user",
        "id_department",
        "image",
        "status"

    ];

    protected $cast = [
        
    ];
}
