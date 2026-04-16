<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Emisoras - DDD & Arquitectura Hexagonal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen">
    <nav class="bg-indigo-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="<?= url('/emisoras') ?>" class="flex-shrink-0 font-bold text-xl tracking-tight">
                        📻 RadioAdmin
                    </a>
                </div>
                <div>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm">Admin</span>
                            <a href="<?= url('/logout') ?>" class="bg-indigo-700 hover:bg-indigo-800 px-3 py-2 rounded-md text-sm font-medium transition-colors">Cerrar Sesión</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <?php if (!empty($error)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p class="font-bold">Error</p>
                <p><?= htmlspecialchars($error) ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($success) && $success === true): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p class="font-bold">Éxito</p>
                <p>Operación realizada correctamente.</p>
            </div>
        <?php endif; ?>

        <?php echo $content ?? ''; ?>
    </main>

    <footer class="bg-gray-800 text-gray-300 py-6 mt-12 text-center">
        <p class="text-sm">© <?= date('Y') ?> RadioAdmin. Arquitectura Hexagonal y DDD en PHP 8.2+.</p>
    </footer>
</body>
</html>
