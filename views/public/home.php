<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directorio de Emisoras | RadioStream</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #0f172a; color: #f8fafc; }
        
        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
            border-color: rgba(99, 102, 241, 0.4);
        }

        .gradient-text {
            background: linear-gradient(135deg, #818cf8 0%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .bg-gradient-header {
            background: radial-gradient(circle at top center, #1e1b4b 0%, #0f172a 100%);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased bg-gradient-header">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 backdrop-blur-md bg-slate-900/60 border-b border-slate-800 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-extrabold tracking-tight">
                Radio<span class="text-indigo-400">Stream</span>
            </h1>
            <div>
                <a href="<?= url('/login') ?>" class="text-sm font-medium text-slate-300 hover:text-white bg-slate-800 hover:bg-slate-700 px-4 py-2 rounded-full transition-colors border border-slate-700">
                    Acceso Radiodifusores
                </a>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="py-20 text-center px-4">
        <h2 class="text-5xl md:text-6xl font-extrabold mb-6">
            Sintoniza tu <span class="gradient-text">Frecuencia Ideal</span>
        </h2>
        <p class="text-slate-400 text-lg md:text-xl max-w-2xl mx-auto">
            Explora nuestra colección de estaciones de radio premium. Desde noticias de última hora hasta los beats más intensos de la noche.
        </p>
    </header>

    <!-- Main Content Grid -->
    <main class="flex-grow max-w-7xl mx-auto px-6 pb-24 w-full">
        <?php if (empty($emisoras)): ?>
            <div class="text-center py-20 bg-slate-800/30 rounded-3xl border border-slate-800">
                <svg class="mx-auto h-16 w-16 text-slate-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                </svg>
                <h3 class="text-xl font-medium text-slate-300">No hay emisoras disponibles</h3>
                <p class="text-slate-500 mt-2">Nuestros radiodifusores están preparando nuevas estaciones.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($emisoras as $emisora): ?>
                    <a href="<?= url('/radio/' . htmlspecialchars($emisora->id()->value())) ?>" class="block group">
                        <article class="glass-card rounded-2xl p-6 h-full flex flex-col relative overflow-hidden">
                            <!-- Decorational Gradient Blob -->
                            <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-500/20 rounded-full blur-2xl group-hover:bg-purple-500/30 transition-colors"></div>
                            
                            <div class="mb-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-800 text-indigo-300 border border-slate-700 mb-3">
                                    <?= htmlspecialchars($emisora->genero()) ?>
                                </span>
                                <h3 class="text-2xl font-bold text-white group-hover:text-indigo-200 transition-colors">
                                    <?= htmlspecialchars($emisora->nombre()) ?>
                                </h3>
                                <p class="text-slate-400 text-sm mt-1 line-clamp-2">
                                    <?= htmlspecialchars($emisora->descripcion() ?? 'Sin descripción disponible.') ?>
                                </p>
                            </div>
                            
                            <div class="mt-auto pt-4 border-t border-slate-700/50 flex justify-between items-end">
                                <div>
                                    <p class="text-xs text-slate-500 mb-1">Frecuencia</p>
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono text-lg font-semibold text-indigo-400">
                                            <?= htmlspecialchars($emisora->bandaFm()->value() ?? $emisora->bandaAm()->value()) ?>
                                        </span>
                                        <span class="text-xs text-slate-400 uppercase">
                                            <?= !empty($emisora->bandaFm()->value()) ? 'FM' : 'AM' ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="bg-indigo-600/20 p-2 rounded-full group-hover:bg-indigo-500 group-hover:text-white text-indigo-400 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </article>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <footer class="mt-auto py-8 text-center text-slate-500 text-sm border-t border-slate-800">
        <p>&copy; <?= date('Y') ?> RadioStream. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
