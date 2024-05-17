<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cofres extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuarios_id',
        'totalGuardado',
        'maiorAporte',
        'meta',
        'rendimento'
    ];
}
