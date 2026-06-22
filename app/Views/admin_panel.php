<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración | Jardín Etnobiológico</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-jardin { background-color: #2D4A22; }
        .text-jardin { color: #2D4A22; }
        .hover-bg-jardin:hover { background-color: #2D4A22; color: white; }
    </style>
</head>
<body class="bg-stone-100 min-h-screen">

    <nav class="bg-jardin text-white px-8 py-5 shadow-md flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold tracking-wide">JARDÍN ETNOBIOLÓGICO DE OAXACA</h1>
            <h2 class="text-sm font-light opacity-90">Panel de Administración Central</h2>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm font-semibold">Hola, Admin</span>
            <a href="<?= base_url('/') ?>" class="bg-white text-jardin px-4 py-2 rounded shadow text-sm font-bold hover:bg-stone-200 transition">Ver Sitio Web</a>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10 text-center">
            <h2 class="text-3xl font-extrabold text-gray-800">Sistema Bibliotecario</h2>
            <p class="mt-2 text-gray-600">Selecciona el módulo al que deseas ingresar.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <a href="<?= base_url('/admin') ?>" class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-green-800 flex flex-col h-full transform hover:-translate-y-1">
                <div class="p-8 flex-grow">
                    <div class="w-14 h-14 rounded-full bg-orange-100 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Fichas Pendientes</h3>
                    <p class="text-gray-500 text-sm">Modera las temáticas sugeridas por los lectores y asigna la ubicación física de los libros devueltos a la mesa.</p>
                </div>
                <div class="bg-stone-50 px-8 py-4 border-t border-gray-100 text-jardin font-bold text-sm flex justify-between items-center group-hover:bg-jardin group-hover:text-white transition-colors">
                    <span>Ir a Pendientes</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </a>

            <a href="<?= base_url('/completadas') ?>" class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-green-800 flex flex-col h-full transform hover:-translate-y-1">
                <div class="p-8 flex-grow">
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Historial y Reportes</h3>
                    <p class="text-gray-500 text-sm">Consulta el archivo histórico de fichas completadas, filtra por fechas y exporta lotes en formato PDF para impresión.</p>
                </div>
                <div class="bg-stone-50 px-8 py-4 border-t border-gray-100 text-jardin font-bold text-sm flex justify-between items-center group-hover:bg-jardin group-hover:text-white transition-colors">
                    <span>Ir al Historial</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </a>

            <a href="<?= base_url('/biblioteca') ?>" target="_blank" class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-green-800 flex flex-col h-full transform hover:-translate-y-1">
                <div class="p-8 flex-grow">
                    <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Kiosco de Registro</h3>
                    <p class="text-gray-500 text-sm">Abre la pantalla pública del formulario para que los lectores registren sus fichas. (Se abre en pestaña nueva).</p>
                </div>
                <div class="bg-stone-50 px-8 py-4 border-t border-gray-100 text-jardin font-bold text-sm flex justify-between items-center group-hover:bg-jardin group-hover:text-white transition-colors">
                    <span>Abrir Kiosco</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </div>
            </a>

            <a href="<?= base_url('/mapa') ?>" class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-green-800 flex flex-col h-full transform hover:-translate-y-1">
                <div class="p-8 flex-grow">
                    <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Mapa Interactivo</h3>
                    <p class="text-gray-500 text-sm">Visualiza el croquis de la biblioteca, busca libros y encuentra su ubicación física en los libreros en tiempo real.</p>
                </div>
                <div class="bg-stone-50 px-8 py-4 border-t border-gray-100 text-jardin font-bold text-sm flex justify-between items-center group-hover:bg-jardin group-hover:text-white transition-colors">
                    <span>Ver Mapa</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </a>

        </div>

    </main>

</body>
</html>