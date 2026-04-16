<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Service\MailerInterface;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

/**
 * Adaptador para PHPMailer que implementa la interfaz de dominio.
 */
class PHPMailerAdapter implements MailerInterface
{
    private array $config;

    /**
     * @param array $config Configuración SMTP (generalmente desde config/mail.php)
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function send(string $to, string $subject, string $body): bool
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor
            $mail->isSMTP();
            $mail->Host       = $this->config['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->config['username'];
            $mail->Password   = $this->config['password'];
            $mail->SMTPSecure = $this->config['encryption'] === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $this->config['port'];
            $mail->CharSet    = 'UTF-8';

            // Destinatarios
            $mail->setFrom($this->config['from_email'], $this->config['from_name']);
            $mail->addAddress($to);

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);

            // Previsualización Local (Para pruebas sin SMTP real)
            $logDir = __DIR__ . '/../../../logs';
            if (!is_dir($logDir)) {
                mkdir($logDir, 0777, true);
            }
            file_put_contents($logDir . '/preview_email.html', $body);

            return $mail->send();
        } catch (PHPMailerException $e) {
            error_log("Error al enviar correo con PHPMailer: {$mail->ErrorInfo}");
            return false;
        }
    }
}
