<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\Auth\RequestPasswordResetUseCase;
use PDO;
use Exception;

class AuthController
{
    public function __construct(
        private PDO $connection,
        private RequestPasswordResetUseCase $passwordResetUseCase
    ) {}

    public function login(): void
    {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $stmt = $this->connection->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header('Location: /emisoras');
                exit;
            } else {
                $error = 'Credenciales inválidas.';
            }
        }

        require __DIR__ . '/../../../../views/auth/login.php';
    }

    public function forgotPassword(): void
    {
        $success = false;
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            
            if ($this->passwordResetUseCase->execute($email)) {
                $success = true;
            } else {
                $error = 'Email inválido.';
            }
        }

        require __DIR__ . '/../../../../views/auth/forgot-password.php';
    }

    public function logout(): void
    {
        session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }
}
