<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\Emisora\ListEmisorasUseCase;
use App\Application\UseCase\Emisora\ReadEmisoraUseCase;
use Exception;

/**
 * Controlador para la interfaz pública (Oyentes).
 * Gestiona la visualización del catálogo y el detalle de las emisoras.
 */
class PublicController
{
    public function __construct(
        private ListEmisorasUseCase $listEmisoras,
        private ReadEmisoraUseCase $readEmisora
    ) {}

    public function index(): void
    {
        $emisoras = $this->listEmisoras->execute();
        require __DIR__ . '/../../../../views/public/home.php';
    }

    public function show(string $id): void
    {
        try {
            $emisora = $this->readEmisora->execute($id);
            require __DIR__ . '/../../../../views/public/show.php';
        } catch (Exception $e) {
            // Emisora not found, redirect to public home
            header('Location: /');
            exit;
        }
    }
}
