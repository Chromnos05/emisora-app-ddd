<?php

declare(strict_types=1);

namespace App\Application\UseCase\Emisora;

use App\Domain\EmisoraRepository;
use App\Domain\ValueObject\EmisoraId;
use App\Domain\Exception\EmisoraNotFoundException;

/**
 * Caso de Uso para eliminar una emisora del sistema por su ID.
 */
class DeleteEmisoraUseCase
{
    private EmisoraRepository $repository;

    public function __construct(EmisoraRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id): void
    {
        $emisoraId = new EmisoraId($id);
        $emisora = $this->repository->findById($emisoraId);

        if (!$emisora) {
            throw new EmisoraNotFoundException($id);
        }

        $this->repository->delete($emisoraId);
    }
}
