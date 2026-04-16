<?php

declare(strict_types=1);

namespace App\Application\UseCase\Emisora;

use App\Domain\Emisora;
use App\Domain\EmisoraRepository;

class ListEmisorasUseCase
{
    private EmisoraRepository $repository;

    public function __construct(EmisoraRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Emisora[]
     */
    public function execute(): array
    {
        return $this->repository->findAll();
    }
}
