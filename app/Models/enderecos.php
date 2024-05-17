<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enderecos extends Model
{
    use HasFactory;

    protected $fillable = [
        'rua',
        'cep',
        'bairro',
        'complemento',
        'cidade',
        'estado',
        'numeroResidencia'
    ];
}
