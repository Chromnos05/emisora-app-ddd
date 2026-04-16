<?php

declare(strict_types=1);

namespace App\Application\UseCase\Emisora;

use App\Domain\Emisora;
use App\Domain\EmisoraRepository;
use App\Domain\ValueObject\EmisoraId;
use App\Domain\Exception\EmisoraNotFoundException;

class ReadEmisoraUseCase
{
    private EmisoraRepository $repository;

    public function __construct(EmisoraRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id): Emisora
    {
        $emisoraId = new EmisoraId($id);
        $emisora = $this->repository->findById($emisoraId);

        if (!$emisora) {
            throw new EmisoraNotFoundException($id);
        }

        return $emisora;
    }
}
