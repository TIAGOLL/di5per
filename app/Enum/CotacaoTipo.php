<?php

namespace App\Enum;

enum CotacaoTipo: string
{
    case Abertura = 'abertura';
    case Intermediario = 'intermediario';
    case Fechamento = 'fechamento';

    public function getDes(): string
    {
        return match ($this) {
            CotacaoTipo::Abertura => "Abertura",
            CotacaoTipo::Intermediario => "intermediario",
            CotacaoTipo::Fechamento => "fechamento"
        };
    }
}
