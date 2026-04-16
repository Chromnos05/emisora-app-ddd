<?php

declare(strict_types=1);

require_once __DIR__ . '/../autoload.php';

use App\Application\UseCase\Auth\RequestPasswordResetUseCase;
use App\Application\UseCase\Emisora\CreateEmisoraUseCase;
use App\Application\UseCase\Emisora\DeleteEmisoraUseCase;
use App\Application\UseCase\Emisora\ListEmisorasUseCase;
use App\Application\UseCase\Emisora\ReadEmisoraUseCase;
use App\Application\UseCase\Emisora\UpdateEmisoraUseCase;
use App\Infrastructure\Http\Controller\AuthController;
use App\Infrastructure\Http\Controller\EmisoraController;
use App\Infrastructure\Http\Router;
use App\Infrastructure\Persistence\PdoEmisoraRepository;

session_start();

$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '3306';
$db   = getenv('DB_NAME') ?: 'emisora_app';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: ''; // XAMPP por defecto no usa contraseña para el usuario root

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos. Por favor, asegúrate de levantar los servicios Docker o tener MySQL corriendo localmente.");
}

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

// Dependencias Auth
$resetPassword = new RequestPasswordResetUseCase();
$authController = new AuthController($pdo, $resetPassword);

// Router
$router = new Router();

$router->add('GET', '/', function() {
    header('Location: /emisoras');
    exit;
});

// Auth Routes
$router->add('GET', '/login', [$authController, 'login']);
$router->add('POST', '/login', [$authController, 'login']);
$router->add('GET', '/logout', [$authController, 'logout']);
$router->add('GET', '/recuperar-password', [$authController, 'forgotPassword']);
$router->add('POST', '/recuperar-password', [$authController, 'forgotPassword']);

// Middleware básico
$checkAuth = function() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
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
$router->dispatch($method, $uri);
