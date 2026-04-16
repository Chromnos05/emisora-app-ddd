<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\ValueObject\BandaAm;
use App\Domain\ValueObject\BandaFm;
use App\Domain\ValueObject\EmisoraId;
use App\Domain\Exception\DomainException;

class Emisora
{
    private EmisoraId $id;
    private string $nombre;
    private int $canal;
    private BandaFm $bandaFm;
    private BandaAm $bandaAm;
    private int $numLocutores;
    private string $genero;
    private string $horario;
    private ?string $patrocinador;
    private string $pais;
    private ?string $descripcion;
    private int $numProgramas;
    private int $numCiudades;

    public function __construct(
        EmisoraId $id,
        string $nombre,
        int $canal,
        BandaFm $bandaFm,
        BandaAm $bandaAm,
        int $numLocutores,
        string $genero,
        string $horario,
        ?string $patrocinador,
        string $pais,
        ?string $descripcion,
        int $numProgramas,
        int $numCiudades
    ) {
        if (trim($nombre) === '') {
            throw new DomainException("El nombre de la emisora no puede estar vacío");
        }
        if ($canal <= 0) {
            throw new DomainException("El canal debe ser mayor a 0");
        }

        $this->id = $id;
        $this->nombre = $nombre;
        $this->canal = $canal;
        $this->bandaFm = $bandaFm;
        $this->bandaAm = $bandaAm;
        $this->numLocutores = $numLocutores;
        $this->genero = $genero;
        $this->horario = $horario;
        $this->patrocinador = $patrocinador;
        $this->pais = $pais;
        $this->descripcion = $descripcion;
        $this->numProgramas = $numProgramas;
        $this->numCiudades = $numCiudades;
    }

    public function id(): EmisoraId { return $this->id; }
    public function nombre(): string { return $this->nombre; }
    public function canal(): int { return $this->canal; }
    public function bandaFm(): BandaFm { return $this->bandaFm; }
    public function bandaAm(): BandaAm { return $this->bandaAm; }
    public function numLocutores(): int { return $this->numLocutores; }
    public function genero(): string { return $this->genero; }
    public function horario(): string { return $this->horario; }
    public function patrocinador(): ?string { return $this->patrocinador; }
    public function pais(): string { return $this->pais; }
    public function descripcion(): ?string { return $this->descripcion; }
    public function numProgramas(): int { return $this->numProgramas; }
    public function numCiudades(): int { return $this->numCiudades; }
    
    // Método para crear una nueva emisora
    public static function create(
        string $nombre,
        int $canal,
        ?string $bandaFm,
        ?string $bandaAm,
        int $numLocutores,
        string $genero,
        string $horario,
        ?string $patrocinador,
        string $pais,
        ?string $descripcion,
        int $numProgramas,
        int $numCiudades
    ): self {
        return new self(
            EmisoraId::create(),
            $nombre,
            $canal,
            new BandaFm($bandaFm),
            new BandaAm($bandaAm),
            $numLocutores,
            $genero,
            $horario,
            $patrocinador,
            $pais,
            $descripcion,
            $numProgramas,
            $numCiudades
        );
    }
}
