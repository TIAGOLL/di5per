<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class investimentos extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuarios_id',
        'totalInvestimento',
        'data',
        'rendimento',
        'nome'
    ];
}