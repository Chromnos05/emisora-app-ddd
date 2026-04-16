<?php

declare(strict_types=1);

namespace App\Application\UseCase\Emisora;

use App\Domain\Emisora;
use App\Domain\EmisoraRepository;
use App\Domain\ValueObject\BandaAm;
use App\Domain\ValueObject\BandaFm;
use App\Domain\ValueObject\EmisoraId;
use App\Domain\Exception\EmisoraNotFoundException;

class UpdateEmisoraUseCase
{
    private EmisoraRepository $repository;

    public function __construct(EmisoraRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id, array $data): void
    {
        $emisoraId = new EmisoraId($id);
        $emisoraExistente = $this->repository->findById($emisoraId);

        if (!$emisoraExistente) {
            throw new EmisoraNotFoundException($id);
        }

        // Reconstruimos la entidad validando la data nuevamente
        $emisoraActualizada = new Emisora(
            $emisoraId,
            $data['nombre'],
            (int) $data['canal'],
            new BandaFm($data['bandaFm'] ?? null),
            new BandaAm($data['bandaAm'] ?? null),
            (int) ($data['numLocutores'] ?? 0),
            $data['genero'],
            $data['horario'],
            $data['patrocinador'] ?? null,
            $data['pais'],
            $data['descripcion'] ?? null,
            (int) ($data['numProgramas'] ?? 0),
            (int) ($data['numCiudades'] ?? 0)
        );

        $this->repository->update($emisoraActualizada);
    }
}
