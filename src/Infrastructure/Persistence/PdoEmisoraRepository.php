<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Emisora;
use App\Domain\EmisoraRepository;
use App\Domain\ValueObject\BandaAm;
use App\Domain\ValueObject\BandaFm;
use App\Domain\ValueObject\EmisoraId;
use PDO;

class PdoEmisoraRepository implements EmisoraRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Emisora $emisora): void
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO emisoras (id, nombre, canal, banda_fm, banda_am, num_locutores, genero, horario, patrocinador, pais, descripcion, num_programas, num_ciudades) 
             VALUES (:id, :nombre, :canal, :banda_fm, :banda_am, :num_locutores, :genero, :horario, :patrocinador, :pais, :descripcion, :num_programas, :num_ciudades)'
        );

        $stmt->execute([
            ':id' => $emisora->id()->value(),
            ':nombre' => $emisora->nombre(),
            ':canal' => $emisora->canal(),
            ':banda_fm' => $emisora->bandaFm()->value(),
            ':banda_am' => $emisora->bandaAm()->value(),
            ':num_locutores' => $emisora->numLocutores(),
            ':genero' => $emisora->genero(),
            ':horario' => $emisora->horario(),
            ':patrocinador' => $emisora->patrocinador(),
            ':pais' => $emisora->pais(),
            ':descripcion' => $emisora->descripcion(),
            ':num_programas' => $emisora->numProgramas(),
            ':num_ciudades' => $emisora->numCiudades()
        ]);
    }

    public function findById(EmisoraId $id): ?Emisora
    {
        $stmt = $this->connection->prepare('SELECT * FROM emisoras WHERE id = :id');
        $stmt->execute([':id' => $id->value()]);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$row) {
            return null;
        }

        return $this->mapRowToEmisora($row);
    }

    public function findAll(): array
    {
        $stmt = $this->connection->query('SELECT * FROM emisoras ORDER BY created_at DESC');
        $emisoras = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $emisoras[] = $this->mapRowToEmisora($row);
        }
        
        return $emisoras;
    }

    public function update(Emisora $emisora): void
    {
        $stmt = $this->connection->prepare(
            'UPDATE emisoras SET nombre = :nombre, canal = :canal, banda_fm = :banda_fm, banda_am = :banda_am, 
            num_locutores = :num_locutores, genero = :genero, horario = :horario, patrocinador = :patrocinador, 
            pais = :pais, descripcion = :descripcion, num_programas = :num_programas, num_ciudades = :num_ciudades 
            WHERE id = :id'
        );

        $stmt->execute([
            ':id' => $emisora->id()->value(),
            ':nombre' => $emisora->nombre(),
            ':canal' => $emisora->canal(),
            ':banda_fm' => $emisora->bandaFm()->value(),
            ':banda_am' => $emisora->bandaAm()->value(),
            ':num_locutores' => $emisora->numLocutores(),
            ':genero' => $emisora->genero(),
            ':horario' => $emisora->horario(),
            ':patrocinador' => $emisora->patrocinador(),
            ':pais' => $emisora->pais(),
            ':descripcion' => $emisora->descripcion(),
            ':num_programas' => $emisora->numProgramas(),
            ':num_ciudades' => $emisora->numCiudades()
        ]);
    }

    public function delete(EmisoraId $id): void
    {
        $stmt = $this->connection->prepare('DELETE FROM emisoras WHERE id = :id');
        $stmt->execute([':id' => $id->value()]);
    }

    private function mapRowToEmisora(array $row): Emisora
    {
        return new Emisora(
            new EmisoraId($row['id']),
            $row['nombre'],
            (int) $row['canal'],
            new BandaFm($row['banda_fm']),
            new BandaAm($row['banda_am']),
            (int) $row['num_locutores'],
            $row['genero'],
            $row['horario'],
            $row['patrocinador'],
            $row['pais'],
            $row['descripcion'],
            (int) $row['num_programas'],
            (int) $row['num_ciudades']
        );
    }
}
