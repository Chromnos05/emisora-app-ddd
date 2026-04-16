<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\ValueObject\EmisoraId;

interface EmisoraRepository
{
    public function save(Emisora $emisora): void;
    
    public function findById(EmisoraId $id): ?Emisora;
    
    /**
     * @return Emisora[]
     */
    public function findAll(): array;
    
    public function update(Emisora $emisora): void;
    
    public function delete(EmisoraId $id): void;
}
