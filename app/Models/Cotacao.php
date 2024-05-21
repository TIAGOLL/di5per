<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enum\CotacaoTipo;

class Cotacao extends Model
{
    use HasFactory;
    protected $fillable = [
        'valor',
        'dataHora',
        'descricao',
        'moeda_id'
    ];
    protected $casts = ["descricao" => CotacaoTipo::class];
}
