<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\DomainException;

/**
 * Value Object que representa una frecuencia en la banda AM.
 */
class BandaAm
{
    private ?string $valor;

    public function __construct(?string $valor)
    {
        if ($valor !== null) {
            $valor = trim($valor);
            if ($valor !== '' && !preg_match('/^\d{3,4}$/', $valor)) {
                throw new DomainException("Frecuencia AM inválida. Debe ser un número como '1040'");
            }
        }

        $this->valor = empty($valor) ? null : $valor;
    }

    public function value(): ?string
    {
        return $this->valor;
    }
}
