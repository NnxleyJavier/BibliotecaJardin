<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Panel Admin' ?> | Jardín Etnobiológico</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .bg-jardin { background-color: #2D4A22; }
        .text-jardin { color: #2D4A22; }
    </style>
</head>
<body class="bg-stone-100 min-h-screen">

    <nav class="bg-jardin text-white shadow-md relative z-50">
        <div class="px-6 py-4 flex justify-between items-center">
            
            <div class="flex items-center gap-4">
                <button id="btnMenu" class="p-2 bg-white/10 hover:bg-white/20 rounded-md transition focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                <div>
                    <h1 class="text-lg font-bold tracking-wide">BIBLIOTECA</h1>
                    <p class="text-xs opacity-80">Jardín Etnobiológico de Oaxaca</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-xs hidden sm:inline italic">Administrador</span>
                <div class="w-8 h-8 bg-white text-jardin rounded-full flex items-center justify-center font-bold">A</div>
                
                <a href="<?= base_url('logout') ?>" class="text-xs font-bold bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded transition">
                    Cerrar Sesión
                </a>
            </div>
            </div>
        </div>

        <div id="menuDesplegable" class="hidden absolute left-6 top-full mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden text-gray-800 transition-all">
            
            <a href="<?= base_url('/panel') ?>" class="block px-5 py-4 hover:bg-stone-50 hover:text-jardin border-b border-gray-100 transition font-semibold flex items-center gap-3">
                <span class="text-xl">🏠</span> Menú Principal
            </a>
            
            <a href="<?= base_url('/admin') ?>" class="block px-5 py-4 hover:bg-stone-50 hover:text-jardin border-b border-gray-100 transition font-semibold flex items-center gap-3">
                <span class="text-xl">⏳</span> Fichas Pendientes
            </a>
            
            <a href="<?= base_url('/completadas') ?>" class="block px-5 py-4 hover:bg-stone-50 hover:text-jardin border-b border-gray-100 transition font-semibold flex items-center gap-3">
                <span class="text-xl">🗂️</span> Historial y Lotes PDF
            </a>
            
            <a href="<?= base_url('/') ?>" target="_blank" class="block px-5 py-4 bg-stone-100 hover:bg-stone-200 text-jardin transition font-bold flex justify-between items-center">
                <span class="flex items-center gap-3"><span class="text-xl">💻</span> Ver Kiosco Público</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            </a>
        </div>
    </nav>

    <script>
        const btnMenu = document.getElementById('btnMenu');
        const menuDesplegable = document.getElementById('menuDesplegable');

        // Abre/Cierra al presionar el botón
        btnMenu.addEventListener('click', (e) => {
            e.stopPropagation(); // Evita que se cierre instantáneamente
            menuDesplegable.classList.toggle('hidden');
        });

        // Cierra el menú automáticamente si el usuario hace clic en cualquier parte de la pantalla
        document.addEventListener('click', (event) => {
            if (!btnMenu.contains(event.target) && !menuDesplegable.contains(event.target)) {
                menuDesplegable.classList.add('hidden');
            }
        });
    </script>

    <main class="max-w-7xl mx-auto py-8 px-4">