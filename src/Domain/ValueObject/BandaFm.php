<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\DomainException;

class BandaFm
{
    private ?string $valor;

    public function __construct(?string $valor)
    {
        if ($valor !== null) {
            $valor = trim($valor);
            if ($valor !== '' && !preg_match('/^\d{2,3}\.\d$/', $valor)) {
                throw new DomainException("Frecuencia FM inválida. Debe ser del formato '88.5'");
            }
        }

        $this->valor = empty($valor) ? null : $valor;
    }

    public function value(): ?string
    {
        return $this->valor;
    }
}
