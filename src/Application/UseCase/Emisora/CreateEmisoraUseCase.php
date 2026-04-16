<?php

declare(strict_types=1);

namespace App\Application\UseCase\Emisora;

use App\Domain\Emisora;
use App\Domain\EmisoraRepository;

/**
 * Caso de Uso para la creación de una nueva emisora.
 * Valida los datos de entrada y persiste la entidad en el repositorio.
 */
class CreateEmisoraUseCase
{
    private EmisoraRepository $repository;

    public function __construct(EmisoraRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $data): string
    {
        $emisora = Emisora::create(
            $data['nombre'],
            (int) $data['canal'],
            $data['bandaFm'] ?? null,
            $data['bandaAm'] ?? null,
            (int) ($data['numLocutores'] ?? 0),
            $data['genero'],
            $data['horario'],
            $data['patrocinador'] ?? null,
            $data['pais'],
            $data['descripcion'] ?? null,
            (int) ($data['numProgramas'] ?? 0),
            (int) ($data['numCiudades'] ?? 0)
        );

        $this->repository->save($emisora);

        return $emisora->id()->value();
    }
}
