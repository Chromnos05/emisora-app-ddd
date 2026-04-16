<?php

declare(strict_types=1);

namespace App\Application\UseCase\Auth;

use PDO;
use Exception;

class RegisterUserUseCase
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function execute(string $email, string $password): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El formato del correo es inválido.");
        }

        if (strlen($password) < 6) {
            throw new Exception("La contraseña debe tener al menos 6 caracteres.");
        }

        // Check if user exists
        $stmt = $this->connection->prepare('SELECT id FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            throw new Exception("Ya existe una cuenta con este correo electrónico.");
        }

        // Generate UUID
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $insertStmt = $this->connection->prepare(
            'INSERT INTO users (id, email, password_hash) VALUES (:id, :email, :password_hash)'
        );

        $insertStmt->execute([
            ':id' => $uuid,
            ':email' => $email,
            ':password_hash' => $hash
        ]);
    }
}
