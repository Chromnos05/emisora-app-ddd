<?php
/**
 * Autoloader manual simple compatible con PSR-4.
 * Gestiona la carga de clases tanto de la aplicación (App\) como de PHPMailer.
 */
spl_autoload_register(function ($class) {
    // 1. Manejo de PHPMailer (Instalación manual)
    $phpmailer_prefix = 'PHPMailer\\PHPMailer\\';
    $phpmailer_base_dir = __DIR__ . '/src/Infrastructure/ThirdParty/PHPMailer-6.9.1/src/';

    if (strncmp($phpmailer_prefix, $class, strlen($phpmailer_prefix)) === 0) {
        $relative_class = substr($class, strlen($phpmailer_prefix));
        $file = $phpmailer_base_dir . str_replace('\\', '/', $relative_class) . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }

    // 2. Manejo de la aplicación (Namespace App\)
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
