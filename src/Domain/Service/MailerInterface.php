<?php

declare(strict_types=1);

namespace App\Domain\Service;

/**
 * Interfaz para el servicio de envío de correos electrónicos.
 * Define el contrato que debe seguir cualquier adaptador de correo.
 */
interface MailerInterface
{
    /**
     * Envía un correo electrónico.
     * 
     * @param string $to Dirección del destinatario
     * @param string $subject Asunto del correo
     * @param string $body Contenido del correo (HTML soportado)
     * @return bool True si se envió correctamente, false de lo contrario
     */
    public function send(string $to, string $subject, string $body): bool;
}
