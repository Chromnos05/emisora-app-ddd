<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($emisora->nombre()) ?> | RadioStream</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #0f172a; color: #f8fafc; }
        
        .gradient-text {
            background: linear-gradient(135deg, #818cf8 0%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-gradient {
            background: radial-gradient(circle at center, rgba(99, 102, 241, 0.15) 0%, rgba(15, 23, 42, 1) 70%);
        }

        .glass-panel {
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 backdrop-blur-md bg-slate-900/80 border-b border-slate-800 px-6 py-4">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <a href="<?= url('/') ?>" class="flex items-center text-slate-400 hover:text-white transition-colors group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver al Directorio
            </a>
            <h1 class="text-xl font-bold tracking-tight">
                Radio<span class="text-indigo-400">Stream</span>
            </h1>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-gradient relative border-b border-slate-800">
        <!-- Play Button Overlay -->
        <div class="absolute inset-0 flex items-center justify-center opacity-10 pointer-events-none">
            <svg class="w-96 h-96 text-indigo-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 5v14l11-7z"/>
            </svg>
        </div>

        <div class="max-w-5xl mx-auto px-6 py-24 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 mb-4">
                        <?= htmlspecialchars($emisora->genero()) ?>
                    </span>
                    <h2 class="text-5xl md:text-7xl font-extrabold mb-4 tracking-tight">
                        <?= htmlspecialchars($emisora->nombre()) ?>
                    </h2>
                    <div class="flex items-center space-x-4 text-slate-300">
                        <span class="flex items-center">
                            <svg class="h-5 w-5 mr-1 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <?= htmlspecialchars($emisora->pais() ?? 'Desconocido') ?>
                        </span>
                        <span>•</span>
                        <span class="text-indigo-400 font-bold">Cadena de Radio</span>
                    </div>
                </div>
                
                <!-- "Play" Button / Freq -->
                <button class="bg-indigo-600 hover:bg-indigo-500 text-white rounded-full p-4 flex items-center justify-center transition-transform hover:scale-105 shadow-lg shadow-indigo-500/30 group">
                    <div class="text-left mr-4 hidden md:block">
                        <p class="text-xs text-indigo-200">Transmitiendo en</p>
                        <p class="font-mono text-xl font-bold"><?= htmlspecialchars($emisora->bandaFm()->value() ?? $emisora->bandaAm()->value()) ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Content -->
    <main class="flex-grow max-w-5xl mx-auto px-6 py-12 w-full grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column (Description) -->
        <div class="lg:col-span-2 space-y-8">
            <section>
                <h3 class="text-xl font-bold mb-4 text-white">Sobre la Emisora</h3>
                <div class="glass-panel rounded-2xl p-6 text-slate-300 leading-relaxed">
                    <?= nl2br(htmlspecialchars($emisora->descripcion() ?? 'No hay descripción disponible para esta estación.')) ?>
                </div>
            </section>

            <section class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                <div class="glass-panel rounded-2xl p-5 text-center">
                    <p class="text-slate-500 text-sm mb-1">Locutores</p>
                    <p class="text-3xl font-bold text-white"><?= htmlspecialchars((string)$emisora->numLocutores()) ?></p>
                </div>
                <div class="glass-panel rounded-2xl p-5 text-center">
                    <p class="text-slate-500 text-sm mb-1">Programas</p>
                    <p class="text-3xl font-bold text-white"><?= htmlspecialchars((string)$emisora->numProgramas()) ?></p>
                </div>
                <div class="glass-panel rounded-2xl p-5 text-center col-span-2 sm:col-span-1">
                    <p class="text-slate-500 text-sm mb-1">Ciudades</p>
                    <p class="text-3xl font-bold text-white"><?= htmlspecialchars((string)$emisora->numCiudades()) ?></p>
                </div>
            </section>
        </div>

        <!-- Right Column (Meta Info) -->
        <div class="space-y-6">
            <div class="glass-panel rounded-2xl p-6 border-t-4 border-t-purple-500">
                <h4 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-4">Horario de Emisión</h4>
                <div class="flex items-center text-white">
                    <svg class="h-5 w-5 mr-3 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium"><?= htmlspecialchars($emisora->horario()) ?></span>
                </div>
            </div>

            <div class="glass-panel rounded-2xl p-6">
                <h4 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-4">Dial / Frecuencias</h4>
                
                <?php if (!empty($emisora->bandaFm()->value())): ?>
                <div class="flex justify-between items-center py-2 border-b border-slate-700/50">
                    <span class="text-slate-300">Frecuencia Modulada (FM)</span>
                    <span class="font-mono text-indigo-400 font-bold"><?= htmlspecialchars($emisora->bandaFm()->value()) ?></span>
                </div>
                <?php endif; ?>

                <?php if (!empty($emisora->bandaAm()->value())): ?>
                <div class="flex justify-between items-center py-2 border-b border-slate-700/50">
                    <span class="text-slate-300">Amplitud Modulada (AM)</span>
                    <span class="font-mono text-indigo-400 font-bold"><?= htmlspecialchars($emisora->bandaAm()->value()) ?></span>
                </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($emisora->patrocinador())): ?>
            <div class="glass-panel rounded-2xl p-6">
                <h4 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-3">Patrocinador Principal</h4>
                <div class="bg-slate-800/50 rounded-xl p-4 flex items-center">
                    <div class="h-10 w-10 rounded-full bg-slate-700 flex items-center justify-center mr-3 text-slate-400 font-bold">
                        <?= strtoupper(substr($emisora->patrocinador(), 0, 1)) ?>
                    </div>
                    <span class="text-white font-medium"><?= htmlspecialchars($emisora->patrocinador()) ?></span>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="py-8 text-center text-slate-500 text-sm border-t border-slate-800 mt-12">
        <p>&copy; <?= date('Y') ?> RadioStream. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
