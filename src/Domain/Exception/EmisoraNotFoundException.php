<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class EmisoraNotFoundException extends DomainException
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('No se encontró la emisora con el ID: %s', $id));
    }
}
