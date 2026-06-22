<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Fichas | Biblioteca</title>
    <script src="https://cdn.tailwindcss.com"></script>
  <style>
        .bg-jardin { background-color: #2D4A22; }
        
        /* Estilos para la paginación nativa de CodeIgniter 4 */
        .pagination { display: flex; justify-content: center; list-style: none; padding: 0; margin-top: 1.5rem; gap: 0.5rem; }
        .pagination li a, .pagination li span { display: block; padding: 0.5rem 1rem; border-radius: 0.375rem; border: 1px solid #d1d5db; background-color: white; color: #374151; text-decoration: none; transition: all 0.2s; font-weight: 600; font-size: 0.875rem; }
        .pagination li.active span { background-color: #2D4A22; color: white; border-color: #2D4A22; }
        .pagination li a:hover { background-color: #f3f4f6; }
    </style>
</head>
<body class="bg-stone-100 min-h-screen">
    
    <!-- Navbar -->
    <nav class="bg-jardin text-white px-8 py-4 shadow-md flex justify-between items-center">
        <h1 class="text-xl font-bold tracking-wide">Panel - Historial de Consultas</h1>
        <a href="<?= base_url('/admin') ?>" class="text-sm font-semibold bg-white text-jardin px-4 py-2 rounded shadow hover:bg-stone-200 transition">Volver a Pendientes</a>
    </nav>

    <main class="max-w-7xl mx-auto py-10 px-4">
        
        <!-- ==========================================
             1. BUSCADOR POR RANGO DE FECHAS 
             ========================================== -->
        <div class="bg-white p-6 rounded-xl shadow-md mb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Filtrar por rango de fechas</h3>
            
            <!-- Formulario GET para buscar -->
            <form method="GET" action="<?= base_url('/completadas') ?>" class="flex gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" value="<?= isset($fecha_inicio) ? esc($fecha_inicio) : '' ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                    <input type="date" name="fecha_fin" value="<?= isset($fecha_fin) ? esc($fecha_fin) : '' ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin">
                </div>
                <div>
                    <button type="submit" class="bg-jardin hover:bg-green-800 text-white font-bold py-2 px-6 rounded shadow transition">Buscar</button>
                    <a href="<?= base_url('/completadas') ?>" class="ml-2 text-gray-500 hover:text-gray-800 text-sm font-semibold">Limpiar Filtro</a>
                </div>
            </form>
        </div>

        <!-- ==========================================
             2. TABLA DE RESULTADOS Y CHECKBOXES DE LOTE
             ========================================== -->
        <!-- Formulario POST para imprimir múltiples PDFs -->
        <form action="<?= base_url('/imprimir_lote') ?>" method="POST" target="_blank">
            
            <div class="mb-4 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Resultados</h3>
                <button type="submit" class="bg-gray-800 hover:bg-black text-white font-bold py-2 px-6 rounded shadow transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Imprimir Fichas Seleccionadas
                </button>
            </div>

            <!-- Tabla -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-stone-50">
                        <tr>
                            <!-- Checkbox Maestro -->
                            <th class="px-6 py-4 text-left">
                                <input type="checkbox" id="selectAll" class="w-4 h-4 text-jardin rounded border-gray-300 cursor-pointer">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Ficha #</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Libro</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Lector</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase">Individual</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if(!empty($fichas_completadas)): ?>
                            <?php foreach($fichas_completadas as $ficha): ?>
                                <tr class="hover:bg-stone-50">
                                    <td class="px-6 py-4">
                                        <!-- Checkbox individual -->
                                        <input type="checkbox" name="fichas_seleccionadas[]" value="<?= $ficha['id_ficha'] ?>" class="ficha-checkbox w-4 h-4 text-jardin rounded border-gray-300 cursor-pointer">
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900"><?= str_pad($ficha['id_ficha'], 5, '0', STR_PAD_LEFT) ?></td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-800"><?= esc($ficha['titulo']) ?></div>
                                        <div class="text-xs text-gray-500"><?= esc($ficha['clasificacion_lomo']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800"><?= esc($ficha['nombre_completo']) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-500"><?= date('d/m/Y', strtotime($ficha['fecha_solicitud'])) ?></td>
                                    <td class="px-6 py-4 text-center">
                                        <!-- Botón para imprimir solo esta ficha (Por si no quieren usar lote) -->
                                        <a href="<?= base_url('/descargar_pdf/' . $ficha['id_ficha']) ?>" target="_blank" 
                                           class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded shadow transition inline-flex items-center text-xs">
                                            PDF Único
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500 text-lg">No se encontraron fichas en estas fechas.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
           </div> <!-- Cierre del div .bg-white de la tabla -->

            <!-- AQUÍ IMPRIMIMOS LOS BOTONES DE PAGINACIÓN -->
      <?php if ($pager) :?>
                <div class="mt-6 flex justify-center">
                    <?= $pager->links() ?>
                </div>
            <?php endif ?>

        </form>

    </main>

    <!-- Script JavaScript para que el checkbox de arriba seleccione todos los de abajo -->
    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.ficha-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
</body>
</html>