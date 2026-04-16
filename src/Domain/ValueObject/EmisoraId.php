<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\DomainException;
use InvalidArgumentException;

/**
 * Value Object que representa el Identificador Único de una Emisora.
 * Implementa un formato UUID v4 para garantizar la unicidad global.
 */
class EmisoraId
{
    private string $id;

    public function __construct(string $id)
    {
        if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $id)) {
            throw new DomainException('El ID de la emisora debe ser un UUID válido.');
        }

        $this->id = $id;
    }

    public static function create(): self
    {
        // Generar un UUID v4 básico sin dependencias externas
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

        return new self($uuid);
    }

    public function value(): string
    {
        return $this->id;
    }

    public function equals(EmisoraId $other): bool
    {
        return $this->id === $other->value();
    }
}
