<?php

declare(strict_types=1);

namespace App\Application\UseCase\Auth;

use PDO;
use Exception;

/**
 * Caso de Uso para restablecer la contraseña utilizando un token de validación.
 */
class ResetPasswordUseCase
{
    private PDO $connection;

    /**
     * @param PDO $connection Conexión a la base de datos
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Ejecuta el cambio de contraseña.
     * 
     * @param string $token Token de validación
     * @param string $newPassword Nueva contraseña en texto plano
     * @return bool True si se cambió con éxito
     */
    public function execute(string $token, string $newPassword): bool
    {
        // Verificar token y expiración
        $stmt = $this->connection->prepare(
            "SELECT id FROM users WHERE reset_token = :token AND reset_expires_at > NOW()"
        );
        $stmt->execute([':token' => $token]);
        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }

        // Actualizar contraseña y limpiar token
        $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $this->connection->prepare(
            "UPDATE users SET password_hash = :hash, reset_token = NULL, reset_expires_at = NULL WHERE id = :id"
        );
        
        return $stmt->execute([
            ':hash' => $passwordHash,
            ':id' => $user['id']
        ]);
    }

    /**
     * Valida si un token es válido y no ha expirado.
     */
    public function isValidToken(string $token): bool
    {
        $stmt = $this->connection->prepare(
            "SELECT id FROM users WHERE reset_token = :token AND reset_expires_at > NOW()"
        );
        $stmt->execute([':token' => $token]);
        return (bool) $stmt->fetch();
    }
}
