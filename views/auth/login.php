<?php ob_start(); ?>

<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 mt-10">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg border border-gray-100">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Iniciar Sesión
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Accede a RadioAdmin
            </p>
        </div>
        
        <form class="mt-8 space-y-6" action="<?= url('/login') ?>" method="POST">
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="email-address" class="sr-only">Correo Electrónico</label>
                    <input id="email-address" name="email" type="email" autocomplete="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Correo Electrónico (admin@emisora.com)">
                </div>
                <div>
                    <label for="password" class="sr-only">Contraseña</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Contraseña (admin123)">
                </div>
            </div>

            <div class="flex flex-col space-y-3">
                <div class="text-sm text-center">
                    <a href="<?= url('/recuperar-password') ?>" class="font-medium text-indigo-600 hover:text-indigo-500">
                        ¿Olvidó su contraseña?
                    </a>
                </div>
                <div class="text-sm text-center border-t pt-3 border-gray-200">
                    <a href="<?= url('/registro') ?>" class="font-medium text-indigo-600 hover:text-indigo-500">
                        ¿No tienes cuenta? Regístrate aquí
                    </a>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Ingresar
                </button>
            </div>
        </form>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
