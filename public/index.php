<?php

declare(strict_types=1);

require_once __DIR__ . '/../autoload.php';

use App\Application\UseCase\Auth\RequestPasswordResetUseCase;
use App\Application\UseCase\Auth\ResetPasswordUseCase;
use App\Application\UseCase\Auth\RegisterUserUseCase;
use App\Application\UseCase\Emisora\CreateEmisoraUseCase;
use App\Application\UseCase\Emisora\DeleteEmisoraUseCase;
use App\Application\UseCase\Emisora\ListEmisorasUseCase;
use App\Application\UseCase\Emisora\ReadEmisoraUseCase;
use App\Application\UseCase\Emisora\UpdateEmisoraUseCase;
use App\Infrastructure\Http\Controller\AuthController;
use App\Infrastructure\Http\Controller\EmisoraController;
use App\Infrastructure\Http\Controller\PublicController;
use App\Infrastructure\Http\Router;
use App\Infrastructure\Persistence\PdoEmisoraRepository;
use App\Infrastructure\Service\PHPMailerAdapter;

session_start();

// Configuración de base de datos
$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '3306';
$db   = getenv('DB_NAME') ?: 'emisora_app';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos.");
}

// Cargar configuración de correo
$mailConfig = require_once __DIR__ . '/../config/mail.php';
$mailer = new PHPMailerAdapter($mailConfig);

// Dependencias Emisora
$emisoraRepo = new PdoEmisoraRepository($pdo);
$createEmisora = new CreateEmisoraUseCase($emisoraRepo);
$readEmisora = new ReadEmisoraUseCase($emisoraRepo);
$updateEmisora = new UpdateEmisoraUseCase($emisoraRepo);
$deleteEmisora = new DeleteEmisoraUseCase($emisoraRepo);
$listEmisoras = new ListEmisorasUseCase($emisoraRepo);

$emisoraController = new EmisoraController(
    $createEmisora, $readEmisora, $updateEmisora, $deleteEmisora, $listEmisoras
);

$publicController = new PublicController($listEmisoras, $readEmisora);

// Dependencias Auth
$requestReset = new RequestPasswordResetUseCase($pdo, $mailer);
$completeReset = new ResetPasswordUseCase($pdo);
$registerUser = new RegisterUserUseCase($pdo);

$authController = new AuthController(
    $pdo, 
    $requestReset, 
    $registerUser, 
    $completeReset
);

/**
 * Helper global para generar URLs absolutas dinámicas.
 */
function url(string $path = '/'): string {
    $scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
    $basePath = str_replace('\\', '/', dirname($scriptPath));
    if ($basePath === '/' || $basePath === '.') $basePath = '';
    $path = '/' . ltrim($path, '/');
    return $basePath . $path;
}

// Router
$router = new Router();

$router->add('GET', '/', [$publicController, 'index']);
$router->add('GET', '/radio/{id}', [$publicController, 'show']);

// Auth Routes
$router->add('GET', '/login', [$authController, 'login']);
$router->add('POST', '/login', [$authController, 'login']);
$router->add('GET', '/logout', [$authController, 'logout']);
$router->add('GET', '/recuperar-password', [$authController, 'forgotPassword']);
$router->add('POST', '/recuperar-password', [$authController, 'forgotPassword']);
$router->add('GET', '/restablecer-password', [$authController, 'resetPassword']);
$router->add('POST', '/restablecer-password', [$authController, 'resetPassword']);
$router->add('GET', '/registro', [$authController, 'register']);
$router->add('POST', '/registro', [$authController, 'register']);

// Middleware básico
$checkAuth = function() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . url('/login'));
        exit;
    }
};

// Emisora Routes
$router->add('GET', '/emisoras', function() use ($emisoraController, $checkAuth) {
    $checkAuth();
    $emisoraController->index();
});

$router->add('GET', '/emisoras/crear', function() use ($emisoraController, $checkAuth) {
    $checkAuth();
    $emisoraController->create();
});

$router->add('POST', '/emisoras/crear', function() use ($emisoraController, $checkAuth) {
    $checkAuth();
    $emisoraController->create();
});

$router->add('GET', '/emisoras/editar/{id}', function($id) use ($emisoraController, $checkAuth) {
    $checkAuth();
    $emisoraController->edit($id);
});

$router->add('POST', '/emisoras/editar/{id}', function($id) use ($emisoraController, $checkAuth) {
    $checkAuth();
    $emisoraController->edit($id);
});

$router->add('POST', '/emisoras/eliminar/{id}', function($id) use ($emisoraController, $checkAuth) {
    $checkAuth();
    $emisoraController->delete($id);
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$uri = (string) parse_url($uri, PHP_URL_PATH);

$scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$basePath = str_replace('\\', '/', dirname($scriptPath));

if ($basePath !== '/' && $basePath !== '.' && $basePath !== '' && str_starts_with($uri, $basePath)) {
    $uri = substr($uri, strlen($basePath));
}

if (str_starts_with($uri, '/index.php')) {
    $uri = substr($uri, strlen('/index.php'));
}

if (empty($uri) || $uri === '' || $uri === '/') {
    $uri = '/';
}

$router->dispatch($method, $uri);
