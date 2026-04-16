<?php include __DIR__ . '/../layout.php'; ?>

<main class="container mx-auto px-4 py-12 flex items-center justify-center min-h-[80vh]">
    <div class="glass-container p-8 rounded-2xl w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500">
                Nueva Contraseña
            </h1>
            <p class="text-slate-400 mt-2">Ingresa tu nueva clave de acceso</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-500/20 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-6 text-sm">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-emerald-500/20 border border-emerald-500 text-emerald-200 px-4 py-3 rounded-lg mb-6 text-sm text-center">
                <p>¡Contraseña actualizada con éxito!</p>
                <a href="<?= url('/login') ?>" class="inline-block mt-3 font-semibold text-emerald-400 hover:text-emerald-300">
                    Ir al Inicio de Sesión &rarr;
                </a>
            </div>
        <?php else: ?>
            <form action="<?= url('/restablecer-password') ?>" method="POST" class="space-y-6">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Nueva Contraseña</label>
                    <input type="password" name="password" id="password" required 
                           class="w-full bg-slate-800/50 border border-slate-700 rounded-lg px-4 py-3 text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
                </div>

                <div>
                    <label for="password_confirm" class="block text-sm font-medium text-slate-300 mb-2">Confirmar Contraseña</label>
                    <input type="password" name="password_confirm" id="password_confirm" required 
                           class="w-full bg-slate-800/50 border border-slate-700 rounded-lg px-4 py-3 text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-bold py-3 rounded-lg shadow-lg shadow-blue-900/20 transition-all transform hover:scale-[1.02]">
                    Actualizar Contraseña
                </button>
            </form>
        <?php endif; ?>
    </div>
</main>
