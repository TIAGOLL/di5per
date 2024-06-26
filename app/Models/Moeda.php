<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moeda extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'sigla',
        'simbolo'
    ];
}
