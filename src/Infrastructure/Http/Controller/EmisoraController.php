<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\Emisora\CreateEmisoraUseCase;
use App\Application\UseCase\Emisora\DeleteEmisoraUseCase;
use App\Application\UseCase\Emisora\ListEmisorasUseCase;
use App\Application\UseCase\Emisora\ReadEmisoraUseCase;
use App\Application\UseCase\Emisora\UpdateEmisoraUseCase;
use Exception;

class EmisoraController
{
    public function __construct(
        private CreateEmisoraUseCase $createUseCase,
        private ReadEmisoraUseCase $readUseCase,
        private UpdateEmisoraUseCase $updateUseCase,
        private DeleteEmisoraUseCase $deleteUseCase,
        private ListEmisorasUseCase $listUseCase
    ) {}

    public function index(): void
    {
        $emisoras = $this->listUseCase->execute();
        require __DIR__ . '/../../../../views/emisora/list.php';
    }

    public function create(): void
    {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->createUseCase->execute($_POST);
                header('Location: /emisoras');
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        $emisora = null;
        require __DIR__ . '/../../../../views/emisora/form.php';
    }

    public function edit(string $id): void
    {
        $error = null;
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->updateUseCase->execute($id, $_POST);
                header('Location: /emisoras');
                exit;
            }
            $emisora = $this->readUseCase->execute($id);
            require __DIR__ . '/../../../../views/emisora/form.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            $emisoras = $this->listUseCase->execute();
            require __DIR__ . '/../../../../views/emisora/list.php';
        }
    }

    public function delete(string $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->deleteUseCase->execute($id);
            } catch (Exception $e) {
                // handle error silently or set flash message
            }
        }
        header('Location: /emisoras');
        exit;
    }
}
