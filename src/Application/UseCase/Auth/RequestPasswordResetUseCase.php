<?php

declare(strict_types=1);

namespace App\Application\UseCase\Auth;

class RequestPasswordResetUseCase
{
    // Normalmente aquí inyectaríamos un MailerInterface
    // private MailerInterface $mailer;

    public function execute(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Simulación: En un caso real, verificaríamos si el usuario existe.
        // Si existe, generaríamos un token de reseteo, lo guardaríamos en BD 
        // y enviaríamos el correo.
        
        $this->logMailSend($email);

        return true; // Retornamos true siempre para no revelar si el email existe (seguridad)
    }

    private function logMailSend(string $email): void
    {
        // En un entorno de producción usaríamos Monolog o similar.
        // Escribimos al error_log estándar de PHP para la simulación.
        $token = bin2hex(random_bytes(16));
        $logMessage = sprintf(
            "[AUTH MOCK] Enviando enlace de restablecimiento de contraseña a %s. Token: %s",
            $email,
            $token
        );
        
        error_log($logMessage);
    }
}
