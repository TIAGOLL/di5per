<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class autanticacoes extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'expiraEm',
        'atualizadoEm',
        'login',
        'senha',
        'usuarios_id'
    ];
}
