<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración | Biblioteca</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .bg-jardin { background-color: #2D4A22; }
        .text-jardin { color: #2D4A22; }
        .border-jardin { border-color: #2D4A22; }
        .focus-ring-jardin:focus { ring-color: #2D4A22; border-color: #2D4A22; }
        /* Ocultar scrollbar en el modal para que se vea más limpio */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-stone-100 min-h-screen">

    <nav class="bg-jardin text-white px-8 py-4 flex justify-between items-center shadow-md">
        <div>
            <h1 class="text-xl font-bold tracking-wide">JARDÍN ETNOBIOLÓGICO DE OAXACA</h1>
            <h2 class="text-sm font-light opacity-90">Panel de Administración - Biblioteca</h2>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm font-semibold">Hola, Administrador</span>
            <a href="<?= base_url('/logout') ?>" class="bg-white text-jardin px-4 py-2 rounded-md text-sm font-bold hover:bg-stone-200 transition">Salir</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex justify-between items-end">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Fichas Pendientes de Procesar</h2>
                <p class="text-sm text-gray-600 mt-1">Libros consultados recientemente que esperan acomodo en estantes y revisión de temáticas.</p>
            </div>
            <div>
                <input type="text" placeholder="Buscar libro o lector..." class="border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin w-64">
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-stone-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Ficha #</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Libro (Clasificación)</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lector</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Temáticas Sugeridas</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Acción</th>
                    </tr>
                </thead>
            <tbody class="bg-white divide-y divide-gray-200">
    <?php if(!empty($fichas_pendientes)): ?>
        <?php foreach($fichas_pendientes as $ficha): ?>
            <tr class="hover:bg-stone-50 transition">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    <?= str_pad($ficha['id_ficha'], 5, '0', STR_PAD_LEFT) ?>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-bold text-gray-800"><?= esc($ficha['titulo']) ?></div>
                    <div class="text-xs text-gray-500">Folio: <?= esc($ficha['folio_adquisicion']) ?> | Lomo: <?= esc($ficha['clasificacion_lomo']) ?></div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-800"><?= esc($ficha['nombre_completo']) ?></div>
                    <div class="text-xs text-gray-500 text-capitalize"><?= str_replace('_', ' ', $ficha['tipo_lector']) ?></div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    <?= !empty($ficha['tematicas']) ? esc($ficha['tematicas']) : '<span class="italic text-gray-400">Sin sugerencias</span>' ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?= date('d/m/Y H:i', strtotime($ficha['fecha_solicitud'])) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
             <button type="button"
    data-id="<?= esc($ficha['id_ficha']) ?>"
    data-folio="<?= esc($ficha['folio_adquisicion']) ?>"
    data-lomo="<?= esc($ficha['clasificacion_lomo']) ?>"
    data-titulo="<?= esc($ficha['titulo']) ?>"
    data-autor="<?= esc($ficha['autor']) ?>"
    data-volumen="<?= esc($ficha['volumen']) ?>"
    data-lector="<?= esc($ficha['nombre_completo']) ?>"
    data-tematicas="<?= esc($ficha['tematicas']) ?>"
    onclick="abrirModal(this)" 
    class="bg-jardin hover:bg-green-800 text-white font-bold py-2 px-4 rounded transition text-sm">
    Procesar
</button>
                </td>
        
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                <p class="text-lg">No hay fichas pendientes</p>
                <p class="text-sm">Todo el acervo bibliográfico está en su lugar.</p>
            </td>
        </tr>
    <?php endif; ?>
</tbody>
            </table>
        </div>
    </main>

    <div id="modalProcesar" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="cerrarModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                
                <div class="bg-jardin px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-bold text-white" id="modal-title">Procesar y Ubicar Ejemplar</h3>
                    <button type="button" onclick="cerrarModal()" class="text-white hover:text-gray-300">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form id="formProcesarFicha" class="px-6 py-6 space-y-6">
                    <input type="hidden" name="id_ficha" id="modal_id_ficha">

                    <div class="bg-stone-50 p-4 rounded-md border border-stone-200">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider font-bold">Datos del Lector</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-800 font-bold" id="modal_lector"></p>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Título de la Obra</label>
                                <input type="text" name="titulo_libro" id="modal_titulo_libro_input" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin" required>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Autor(es)</label>
                                    <input type="text" name="autor_libro" id="modal_autor_libro_input" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin" required>
                                </div>
                                <div class="sm:col-span-1">
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Volumen</label>
                                    <input type="text" name="volumen_libro" id="modal_volumen_libro_input" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Folio de Adquisición</label>
                                    <input type="text" name="folio_adquisicion" id="modal_folio_adquisicion_input" pattern="\d{6}" maxlength="6" title="Debe contener exactamente 6 números" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin bg-amber-50 font-mono" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Clasificación Lomo</label>
                                    <input type="text" name="clasificacion_lomo" id="modal_clasificacion_input" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin" required>
                                </div>
                            </div>

                        </div>
                        <p class="text-xs text-gray-500 mt-2">Corrige cualquier error tipográfico y asigna la clasificación correcta antes de guardar.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Revisión de Temáticas (Moderación)</label>
                        <p class="text-xs text-gray-500 mb-2">Corrige la ortografía o elimina las etiquetas que no correspondan antes de aprobarlas.</p>
                        <textarea name="tematicas_aprobadas" id="modal_tematicas" rows="2" 
                                  class="w-full border-gray-300 rounded-md shadow-sm p-3 border focus:outline-none focus:ring-2 focus-ring-jardin"
                                  placeholder="Ej. Botánica, Fotografía"></textarea>
                    </div>

                    <div class="border-t pt-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Ubicación Física del Ejemplar</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Fila</label>
                                <select name="fila_ubicacion" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin" required>
                                    <option value="">Selecciona Fila</option>
                                    <option value="A">Fila A</option>
                                    <option value="B">Fila B</option>
                                    <option value="C">Fila C</option>
                                    <option value="D">Fila D</option>
                                    <option value="E">Fila E</option>
                                    <option value="F">Fila F</option>
                                    <option value="G">Fila G</option>
                                    <option value="H">Fila H</option>
                                    <option value="I">Fila I</option>
                                    <option value="J">Fila J</option>
                                    <option value="K">Fila K</option>
                                    <option value="L">Fila L</option>
                                    <option value="M">Fila M</option>
                                    <option value="N">Fila N</option>
                                    <option value="O">Fila O</option>
                                    <option value="P">Fila P</option>
                                    <option value="Q">Fila Q</option>
                                    <option value="R">Fila R</option>
                                    <option value="S">Fila S</option>
                                    <option value="T">Fila T</option>
                                    <option value="U">Fila U</option>
                                    <option value="V">Fila V</option>
                                    <option value="W">Fila W</option>
                                    <option value="X">Fila X</option>
                                    <option value="Y">Fila Y</option>
                                    <option value="Z">Fila Z</option>
                                    <option value="AA">Fila AA</option>
                                    <option value="AB">Fila AB</option>
                                    <option value="AC">Fila AC</option>
                                    <option value="AD">Fila AD</option>
                                    <option value="AE">Fila AE</option>
                                    <option value="AF">Fila AF</option>
                                     <option value="AG">Fila AG</option>
                                      <option value="AH">Fila AH</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Librero / Estante</label>
                                <select name="numero_librero" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin" required>
                                    <option value="">Selecciona Librero</option>
                                    <option value="1">Librero 1</option>
                                    <option value="2">Librero 2</option>
                                    <option value="3">Librero 3</option>
                                    <option value="4">Librero 4</option>
                                    <option value="5">Librero 5</option>
                                    <option value="6">Librero 6</option>
                                    <option value="7">Librero 7</option>
                                    <option value="8">Librero 8</option>
                                    <option value="9">Librero 9</option>
                                    <option value="10">Librero 10</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t -mx-6 -mb-6 mt-6">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-jardin text-base font-medium text-white hover:bg-green-800 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">
                            Aprobar y Asignar Ubicación
                        </button>
                        <button type="button" onclick="cerrarModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Funciones para manejar el Modal
        const modal = document.getElementById('modalProcesar');

        // Función que carga los datos de la tabla al modal
        function abrirModal(idFicha, folio, clasificacion, titulo, autor, volumen, lector, tematicas) {
    
    // Inyectamos los valores a los inputs del modal
    document.getElementById('modal_id_ficha').value = idFicha;
    document.getElementById('modal_folio_adquisicion_input').value = folio;
    document.getElementById('modal_clasificacion_input').value = clasificacion;
    document.getElementById('modal_titulo_libro_input').value = titulo; 
    document.getElementById('modal_autor_libro_input').value = autor; 
    document.getElementById('modal_volumen_libro_input').value = volumen; 
    
    document.getElementById('modal_lector').innerText = lector;
    document.getElementById('modal_tematicas').value = tematicas;
    
    const modalElement = document.getElementById('modalProcesar'); 
    modalElement.classList.remove('hidden');
}
        
        function cerrarModal() {
            const modalElement = document.getElementById('modalProcesar'); 
            modalElement.classList.add('hidden');
            document.getElementById('formProcesarFicha').reset();
        }

        // Petición AJAX para guardar los cambios del Administrador
        document.getElementById('formProcesarFicha').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const form = this;
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = 'Guardando...';
            submitBtn.disabled = true;

            try {
                // Aquí apuntarás a tu controlador Admin.php
                const response = await fetch('<?= base_url('/procesar_ficha') ?>', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const result = await response.json();

                if (result.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Procesado!',
                        text: 'El libro ha sido reubicado y las temáticas fueron actualizadas.',
                        confirmButtonColor: '#2D4A22'
                    }).then((result) => {
                        cerrarModal();
                        window.location.reload(); // Recarga la tabla de pendientes
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: result.message || 'Error al procesar.',
                        confirmButtonColor: '#d33'
                    });
                }
            } catch (error) {
                // Si la conexión falla
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo contactar al servidor, verifica tu código de CI4.',
                    confirmButtonColor: '#d33'
                });
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>