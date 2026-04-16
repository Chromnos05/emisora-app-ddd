<?php

declare(strict_types=1);

/**
 * Configuración del servidor de correo SMTP.
 * Estos valores deben ser actualizados por el usuario según su proveedor de correo.
 */
return [
    'host' => 'sandbox.smtp.mailtrap.io', // Cambiar por smtp.gmail.com para Gmail
    'port' => 2525,                       // 465 o 587 para servicios de producción
    'username' => 'TU_USUARIO_MAILTRAP',   // Reemplazar con credencial real de Mailtrap
    'password' => 'TU_PASSWORD_MAILTRAP',   // Reemplazar con credencial real de Mailtrap
    'from_email' => 'no-reply@radiostream.com',
    'from_name' => 'RadioStream Support',
    'encryption' => 'tls',                // 'ssl' o 'tls'
];
