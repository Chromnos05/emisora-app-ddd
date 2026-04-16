<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\Auth\RequestPasswordResetUseCase;
use App\Application\UseCase\Auth\ResetPasswordUseCase;
use App\Application\UseCase\Auth\RegisterUserUseCase;
use PDO;
use Exception;

/**
 * Controlador encargado de la autenticación de usuarios.
 * Gestiona el login, logout, registro y recuperación de contraseña.
 */
class AuthController
{
    /**
     * @param PDO $connection Conexión a la base de datos
     * @param RequestPasswordResetUseCase $passwordResetUseCase Caso de uso para solicitar recuperación
     * @param RegisterUserUseCase|null $registerUserUseCase Caso de uso para registro
     * @param ResetPasswordUseCase|null $completeResetUseCase Caso de uso para completar recuperación
     */
    public function __construct(
        private PDO $connection,
        private RequestPasswordResetUseCase $passwordResetUseCase,
        private ?RegisterUserUseCase $registerUserUseCase = null,
        private ?ResetPasswordUseCase $completeResetUseCase = null
    ) {}

    /**
     * Maneja el inicio de sesión.
     */
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
                if (session_status() === PHP_SESSION_NONE) session_start();
                $_SESSION['user_id'] = $user['id'];
                header('Location: ' . url('/emisoras'));
                exit;
            } else {
                $error = 'Credenciales inválidas.';
            }
        }

        require __DIR__ . '/../../../../views/auth/login.php';
    }

    /**
     * Maneja la solicitud de recuperación de contraseña (paso 1).
     */
    public function forgotPassword(): void
    {
        $success = false;
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            
            // Obtenemos la URL base del servidor para el enlace del correo
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $host = $_SERVER['HTTP_HOST'];
            $baseUrl = $protocol . "://" . $host . url();

            if ($this->passwordResetUseCase->execute($email, $baseUrl)) {
                $success = true;
            } else {
                $error = 'Email inválido.';
            }
        }

        require __DIR__ . '/../../../../views/auth/forgot-password.php';
    }

    /**
     * Maneja el cambio real de contraseña (paso 2).
     */
    public function resetPassword(): void
    {
        $token = $_GET['token'] ?? $_POST['token'] ?? '';
        $error = null;
        $success = false;

        if (empty($token) || ($this->completeResetUseCase && !$this->completeResetUseCase->isValidToken($token))) {
            $error = 'El enlace de recuperación es inválido o ha expirado.';
            require __DIR__ . '/../../../../views/auth/reset-password.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            if ($password !== $passwordConfirm) {
                $error = 'Las contraseñas no coinciden.';
            } else {
                if ($this->completeResetUseCase && $this->completeResetUseCase->execute($token, $password)) {
                    $success = true;
                } else {
                    $error = 'No se pudo actualizar la contraseña. Reintenta.';
                }
            }
        }

        require __DIR__ . '/../../../../views/auth/reset-password.php';
    }

    /**
     * Maneja el registro de nuevos usuarios.
     */
    public function register(): void
    {
        $error = null;
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            if ($password !== $passwordConfirm) {
                $error = 'Las contraseñas no coinciden.';
            } elseif ($this->registerUserUseCase !== null) {
                try {
                    $this->registerUserUseCase->execute($email, $password);
                    
                    $stmt = $this->connection->prepare('SELECT id FROM users WHERE email = :email');
                    $stmt->execute([':email' => $email]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($user) {
                        if (session_status() === PHP_SESSION_NONE) session_start();
                        $_SESSION['user_id'] = $user['id'];
                        header('Location: ' . url('/emisoras'));
                        exit;
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        require __DIR__ . '/../../../../views/auth/register.php';
    }

    /**
     * Cierra la sesión activa.
     */
    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header('Location: ' . url('/login'));
        exit;
    }
}
