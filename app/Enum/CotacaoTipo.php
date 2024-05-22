<?php

namespace App\Enum;


enum CotacaoTipo: string
{
    case Abertura = 'Abertura';
    case Intermediario = 'Intermediário';
    case Fechamento = 'Fechamento';

    public function getDes(): string
    {
        return match ($this) {
            CotacaoTipo::Abertura => "Abertura",
            CotacaoTipo::Intermediario => "Intermediário",
            CotacaoTipo::Fechamento => "Fechamento"
        };
    }

}
