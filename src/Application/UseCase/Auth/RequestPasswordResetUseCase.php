<?php

declare(strict_types=1);

namespace App\Application\UseCase\Auth;

use App\Domain\Service\MailerInterface;
use PDO;
use Exception;

/**
 * Caso de Uso para solicitar el restablecimiento de una contraseña.
 * Envía un correo electrónico con un token único de recuperación orientado a oyentes.
 */
class RequestPasswordResetUseCase
{
    private PDO $connection;
    private MailerInterface $mailer;

    /**
     * @param PDO $connection Conexión a la base de datos
     * @param MailerInterface $mailer Servicio de envío de correo
     */
    public function __construct(PDO $connection, MailerInterface $mailer)
    {
        $this->connection = $connection;
        $this->mailer = $mailer;
    }

    /**
     * Ejecuta la solicitud de recuperación.
     * 
     * @param string $email Correo electrónico del usuario
     * @param string $baseUrl URL base para el enlace (proporcionada por el helper url())
     * @return bool True si el proceso se inició (incluso si el correo no existe, por seguridad)
     */
    public function execute(string $email, string $baseUrl): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Buscar usuario
        $stmt = $this->connection->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Guardar token en BD
            $stmt = $this->connection->prepare(
                "UPDATE users SET reset_token = :token, reset_expires_at = :expires WHERE email = :email"
            );
            $stmt->execute([
                ':token' => $token,
                ':expires' => $expiresAt,
                ':email' => $email
            ]);

            // Enviar correo
            $resetLink = $baseUrl . "/restablecer-password?token=" . $token;
            return $this->sendResetEmail($email, $resetLink);
        }

        // Si el usuario no existe, retornamos true igual para evitar enumeración de cuentas
        return true;
    }

    /**
     * Envía el correo con diseño premium para oyentes.
     */
    private function sendResetEmail(string $to, string $resetLink): bool
    {
        $subject = "Restablece tu contraseña en RadioStream";
        
        $body = "
        <div style='background-color: #0f172a; color: #f8fafc; font-family: sans-serif; padding: 40px; border-radius: 8px;'>
            <div style='text-align: center; margin-bottom: 30px;'>
                <h1 style='color: #38bdf8; margin: 0;'>RadioStream</h1>
                <p style='color: #94a3b8;'>Tu conexión con la música</p>
            </div>
            
            <div style='background-color: #1e293b; padding: 30px; border-radius: 12px; border: 1px solid #334155;'>
                <h2 style='color: #f1f5f9;'>¿Olvidaste tu contraseña?</h2>
                <p style='line-height: 1.6;'>Hola,</p>
                <p style='line-height: 1.6;'>Recibimos una solicitud para restablecer la contraseña de tu cuenta de oyente en RadioStream. No te preocupes, ¡puedes volver al aire en un momento!</p>
                
                <div style='text-align: center; margin: 40px 0;'>
                    <a href='{$resetLink}' style='background: linear-gradient(to right, #0ea5e9, #2563eb); color: white; padding: 14px 28px; text-decoration: none; border-radius: 50px; font-weight: bold; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);'>
                        Restablecer Contraseña
                    </a>
                </div>
                
                <p style='font-size: 14px; color: #94a3b8;'>Este enlace expirará en 1 hora. Si no solicitaste este cambio, puedes ignorar este correo de forma segura.</p>
            </div>
            
            <div style='text-align: center; margin-top: 30px; font-size: 12px; color: #64748b;'>
                &copy; " . date('Y') . " RadioStream. Todos los derechos reservados.
            </div>
        </div>";

        return $this->mailer->send($to, $subject, $body);
    }
}
