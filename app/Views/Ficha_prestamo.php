<!DOCTYPE html>
<html lang="<?= $idioma_actual ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= lang('Ficha.encabezado.ficha_prestamo') ?> | <?= lang('Ficha.encabezado.subtitulo') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-jardin { background-color: #2D4A22; }
        .text-jardin { color: #2D4A22; }
        .focus-ring-jardin:focus { ring-color: #2D4A22; border-color: #2D4A22; }
    </style>
</head>
<body class="bg-stone-100 min-h-screen py-10 relative">

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
        
        <div class="bg-jardin text-white px-8 py-6 flex flex-col md:flex-row justify-between items-center relative">
            
            <div class="absolute top-4 right-4 flex gap-2 text-xs font-bold">
                <a href="<?= base_url('idioma/es') ?>" class="<?= $idioma_actual == 'es' ? 'underline decoration-2' : 'opacity-70 hover:opacity-100' ?>">ES</a>
                <span>|</span>
                <a href="<?= base_url('idioma/en') ?>" class="<?= $idioma_actual == 'en' ? 'underline decoration-2' : 'opacity-70 hover:opacity-100' ?>">EN</a>
            </div>

            <div class="mt-4 md:mt-0">
                <h1 class="text-2xl font-bold tracking-wide"><?= lang('Ficha.encabezado.titulo_principal') ?></h1>
                <h2 class="text-lg font-light opacity-90"><?= lang('Ficha.encabezado.subtitulo') ?></h2>
            </div>
            <div class="text-center md:text-right mt-4 md:mt-0 pt-2 md:pt-0">
                <span class="block text-sm font-semibold uppercase tracking-wider"><?= lang('Ficha.encabezado.ficha_prestamo') ?></span>
                <span class="block text-2xl font-bold"><?= lang('Ficha.encabezado.interno') ?></span>
            </div>
        </div>

        <form id="formularioFicha" class="p-8 space-y-8">
            
          <section>
    <h3 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-4"><?= lang('Ficha.obra.seccion') ?></h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                <?= lang('Ficha.obra.clasificacion') ?> <span class="text-xs text-gray-400 font-normal"><?= lang('Ficha.obra.ubicacion_folio') ?></span>
            </label>
            <input type="text" name="folio_adquisicion" pattern="\d{6}" maxlength="6" title="Debe contener exactamente 6 números" placeholder="Ej. 001234" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin bg-amber-50" required>
        </div>

        <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Clasificación Lomo</label>
            <input type="text" name="clasificacion_lomo" placeholder="Ej. QK 495 .A26" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin" required>
        </div>

        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1"><?= lang('Ficha.obra.titulo') ?></label>
            <input type="text" name="titulo" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin" required>
        </div>
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1"><?= lang('Ficha.obra.autor') ?></label>
            <input type="text" name="autor" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin" required>
        </div>
        <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 mb-1"><?= lang('Ficha.obra.volumen') ?></label>
            <input type="text" name="volumen" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin">
        </div>
        <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 mb-1"><?= lang('Ficha.obra.anio') ?></label>
            <input type="number" name="anio" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin">
        </div>
    </div>
</section>

            <section class="bg-stone-50 p-6 rounded-lg border border-stone-200">
                <div class="flex items-start gap-4">
                    <div class="mt-1 text-jardin">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    <div class="w-full">
                        <h3 class="text-lg font-semibold text-gray-800"><?= lang('Ficha.catalogo.ayuda') ?></h3>
                        <p class="text-sm text-gray-600 mb-3"><?= lang('Ficha.catalogo.descripcion') ?></p>
                        <input type="text" name="tematica_usuario" class="w-full border-gray-300 rounded-md shadow-sm p-3 border focus:outline-none focus:ring-2 focus-ring-jardin" placeholder="<?= lang('Ficha.catalogo.placeholder') ?>">
                    </div>
                </div>
            </section>

            <section>
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-4"><?= lang('Ficha.lector.seccion') ?></h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lang('Ficha.lector.nombre') ?></label>
                        <input type="text" name="nombre_lector" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin" required>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lang('Ficha.lector.institucion') ?></label>
                        <input type="text" name="institucion" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin" placeholder="<?= lang('Ficha.lector.inst_place') ?>">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lang('Ficha.lector.ocupacion') ?></label>
                        <input type="text" name="ocupacion" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lang('Ficha.lector.pais') ?></label>
                        <input type="text" name="pais" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin" value="México">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lang('Ficha.lector.estado') ?></label>
                        <input type="text" name="estado" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin" value="Oaxaca">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lang('Ficha.lector.telefono') ?></label>
                        <input type="tel" name="telefono" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin" required>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lang('Ficha.lector.fecha') ?></label>
                        <input type="date" name="fecha" class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:outline-none focus:ring-2 focus-ring-jardin" value="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>
            </section>

            <section class="pt-4 border-t">
                <div class="flex items-start mb-6">
                    <div class="flex items-center h-5">
                        <input id="privacidad" name="privacidad" type="checkbox" class="w-4 h-4 text-jardin bg-gray-100 border-gray-300 rounded focus:ring-jardin" required>
                    </div>
                    <label for="privacidad" class="ms-2 text-sm font-medium text-gray-600">
                        <?= lang('Ficha.privacidad.acepto') ?> <a href="#" class="text-jardin hover:underline"><?= lang('Ficha.privacidad.enlace') ?></a>. <?= lang('Ficha.privacidad.texto') ?>
                    </label>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-jardin hover:bg-green-800 text-white font-bold py-3 px-8 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1">
                        <?= lang('Ficha.privacidad.boton') ?>
                    </button>
                </div>
            </section>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('formularioFicha').addEventListener('submit', async function(e) {
            e.preventDefault(); // Evita que la página se recargue

            const form = this;
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            
            // Efecto visual: Cambiamos el texto del botón y lo deshabilitamos
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<?= lang('Ficha.privacidad.guardando') ?>';
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-70', 'cursor-not-allowed');

            try {
                // Hacemos la petición AJAX usando Fetch
                const response = await fetch('<?= base_url('/guardar_ficha') ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Le dice a CodeIgniter que es AJAX
                    }
                });

                const result = await response.json();

                // Evaluamos la respuesta de CodeIgniter
                if (result.status === 'success') {
                    
                    // Alerta de Éxito
                    Swal.fire({
                        icon: 'success',
                        title: result.title,
                        text: result.message,
                        confirmButtonColor: '#2D4A22',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        form.reset(); // Limpiamos el formulario automáticamente
                        // Restauramos valores por defecto para el siguiente lector
                        form.querySelector('input[name="pais"]').value = 'México';
                        form.querySelector('input[name="estado"]').value = 'Oaxaca';
                        form.querySelector('input[name="fecha"]').value = '<?= date('Y-m-d') ?>';
                    });

                } else if (result.status === 'error' && result.errors) {
                    
                    // Alerta de Validación
                    let errorMessages = Object.values(result.errors).join('<br>');
                    Swal.fire({
                        icon: 'warning',
                        title: result.title,
                        html: errorMessages,
                        confirmButtonColor: '#2D4A22'
                    });

                } else {
                    // Alerta de Error General en Base de Datos
                    Swal.fire({
                        icon: 'error',
                        title: result.title,
                        text: result.message,
                        confirmButtonColor: '#d33'
                    });
                }

            } catch (error) {
                // Alerta si falla la conexión al servidor
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo conectar con el servidor. Verifica tu internet.',
                    confirmButtonColor: '#d33'
                });
            } finally {
                // Restauramos el botón a la normalidad
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-70', 'cursor-not-allowed');
            }
        });
    </script>

</body>
</html>