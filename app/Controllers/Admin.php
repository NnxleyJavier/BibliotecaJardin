<?php
namespace App\Controllers;

use App\Models\FichaMovimientoModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Admin extends BaseController
{
    public function index()
    {
        $fichaModel = new FichaMovimientoModel();
        
        // Obtenemos las fichas pendientes usando la función que acabamos de crear
        $data = [
            'fichas_pendientes' => $fichaModel->obtenerFichasPendientes()
        ];
        
       return view('header')
             . view('admin_fichas', $data)
             . view('footer');
    }
public function procesar_ficha()
    {
     // 1. Validaciones básicas
      $reglas = [
            'id_ficha'          => 'required|numeric',
            'folio_adquisicion' => 'required|exact_length[6]|numeric', // <--- VALIDACIÓN DEL FOLIO
            'titulo_libro'      => 'required',
            'autor_libro'       => 'required',
            'clasificacion_lomo'=> 'required',
            'fila_ubicacion'    => 'required',
            'numero_librero'    => 'required'
        ];

        if (!$this->validate($reglas)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Faltan datos obligatorios o el título está vacío.'
            ]);
        }

        $datosPost = $this->request->getPost();
        
        // 2. Usamos el Modelo para hacer la búsqueda (¡Como debe ser!)
        $ubicacionModel = new \App\Models\UbicacionModel();
        $id_ubicacion = $ubicacionModel->obtenerIdPorFilaYEstante($datosPost['fila_ubicacion'], $datosPost['numero_librero']);

        // Si el modelo nos regresa null, detenemos todo
        if (!$id_ubicacion) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'El estante seleccionado no existe en el sistema.'
            ]);
        }

        // 3. Le pasamos el ID real encontrado al arreglo y llamamos al modelo de la ficha
        $datosPost['id_ubicacion'] = $id_ubicacion;
        $fichaModel = new \App\Models\FichaMovimientoModel();

        // Ejecutamos la transacción en el modelo principal
        if ($fichaModel->procesarFichaAdmin($datosPost)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Ocurrió un error en la base de datos al intentar procesar.'
            ]);
        }
    }

public function completadas()
    {
        $fichaModel = new \App\Models\FichaMovimientoModel();
        
        $fechaInicio = $this->request->getGet('fecha_inicio');
        $fechaFin    = $this->request->getGet('fecha_fin');
        
        // Atrapamos el parámetro de orden, si no existe o es inválido, por defecto será ASC
        $orden = $this->request->getGet('orden');
        if ($orden !== 'DESC') {
            $orden = 'ASC';
        }

        $data = [
            // Pasamos la nueva variable $orden a la función
            'fichas_completadas' => $fichaModel->obtenerFichasCompletadasPaginadas($fechaInicio, $fechaFin, 20, $orden),
            'pager'              => $fichaModel->pager,
            'fecha_inicio'       => $fechaInicio,
            'fecha_fin'          => $fechaFin,
            'orden'              => $orden // Lo pasamos a la vista para recordar qué opción seleccionó el usuario
        ];

        return view('header')
             . view('admin_completadas', $data)
             . view('footer');
    }

    public function descargar_pdf($id_ficha)
    {
        $fichaModel = new \App\Models\FichaMovimientoModel();
        $datosFicha = $fichaModel->obtenerDetallesFichaParaPDF($id_ficha);

        if (!$datosFicha) {
            return redirect()->back()->with('error', 'La ficha no existe o no se encontraron datos.');
        }

        // 1. Cargamos la vista HTML especial para el PDF y le pasamos los datos
        $html = view('plantilla_pdf', ['ficha' => $datosFicha]);

        // 2. Configuramos Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true); // Permite cargar imágenes/CSS externos si los necesitas
        $dompdf = new Dompdf($options);

        // 3. Le pasamos el HTML a la librería
        $dompdf->loadHtml($html);

        // 4. Configuramos el tamaño del papel (Media Carta o Carta)
        $dompdf->setPaper('letter', 'portrait');

        // 5. Renderizamos y forzamos la descarga (o lo mostramos en el navegador)
        $dompdf->render();
        
        // 'Attachment' => false hace que se abra en el navegador en lugar de descargar directo
        $dompdf->stream("Ficha_Prestamo_" . str_pad($id_ficha, 5, '0', STR_PAD_LEFT) . ".pdf", ["Attachment" => false]);
    }

    public function imprimir_lote()
    {
        // Recibimos los IDs de los checkboxes marcados
        $ids_seleccionados = $this->request->getPost('fichas_seleccionadas');

        if (empty($ids_seleccionados)) {
            // Si le dio a imprimir sin seleccionar nada, lo regresamos con un error
            return redirect()->back()->with('error', 'Debes seleccionar al menos una ficha para imprimir.');
        }

        $fichaModel = new \App\Models\FichaMovimientoModel();
        $fichas = $fichaModel->obtenerDetallesFichasPorLote($ids_seleccionados);

        if (empty($fichas)) {
            return redirect()->back()->with('error', 'No se encontraron datos para las fichas seleccionadas.');
        }

        // Cargamos una nueva vista diseñada para múltiples fichas
        $html = view('plantilla_pdf_lote', ['fichas' => $fichas]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();
        
        $dompdf->stream("Fichas_Lote_" . date('Ymd_His') . ".pdf", ["Attachment" => false]);
    }

    public function panel()
    {
        // Carga la vista del menú principal del administrador
        return view('header')
             . view('admin_panel')
             . view('footer');
    }

    public function importar_revistas()
    {
        // Si el formulario se envía
        if ($this->request->getMethod() === 'post') {
            $archivo = $this->request->getFile('archivo_csv');
            
            if ($archivo && $archivo->isValid() && !$archivo->hasMoved()) {
                $libroModel = new \App\Models\LibroModel();
                $db = \Config\Database::connect();
                
                // Leemos el archivo temporal
                $contenidoCsv = file_get_contents($archivo->getTempName());
                $lineas = explode("\n", $contenidoCsv);
                
                $registrosInsertados = 0;
                
                $db->transStart();
                
                foreach ($lineas as $indice => $linea) {
                    // Saltar la cabecera (primera línea) o líneas en blanco
                    if ($indice === 0 || empty(trim($linea))) {
                        continue; 
                    }
                    
                    // Separar los datos por punto y coma
                    $datos = str_getcsv($linea, ';'); 
                    
                    // Asegurarse de que la línea tenga contenido suficiente
                    if (count($datos) < 3) continue; 
                    
                    // 1. Formatear la fecha
                    $fecha_sql = null;
                    if (!empty($datos[0])) {
                        $fecha_partes = explode('/', trim($datos[0]));
                        if (count($fecha_partes) == 3) {
                            $fecha_sql = $fecha_partes[2] . '-' . $fecha_partes[1] . '-' . $fecha_partes[0];
                        }
                    }
                    
                    // 2. Agregar el prefijo al folio de adquisición
                    $folio_original = trim($datos[1] ?? '');
                    $folio_con_prefijo = 'REV-' . $folio_original;

                    // --- NUEVA LÓGICA DE UBICACIÓN AUTOMÁTICA ---
                    $letra_librero = trim($datos[17] ?? ''); // Penúltima columna
                    $numero_fila   = trim($datos[18] ?? ''); // Última columna
                    $id_ubicacion_asignada = null;

                    if (!empty($letra_librero) && !empty($numero_fila)) {
                        // Buscamos si ese mueble y repisa ya existen en la base de datos
                        $ubicacionExistente = $db->table('ubicaciones')
                                                 ->where('codigo_librero', $letra_librero)
                                                 ->where('fila', $numero_fila)
                                                 ->get()
                                                 ->getRow();

                        if ($ubicacionExistente) {
                            // Si ya existe, tomamos su ID
                            $id_ubicacion_asignada = $ubicacionExistente->id_ubicacion;
                        } else {
                            // Si es un lugar nuevo, lo creamos en este instante
                            $db->table('ubicaciones')->insert([
                                'codigo_librero' => $letra_librero,
                                'fila'           => $numero_fila
                            ]);
                            $id_ubicacion_asignada = $db->insertID(); // Obtenemos el ID recién creado
                        }
                    }
                    // ---------------------------------------------
                    
                    // Mapeo de datos para la base de datos
                    $datosInsertar = [
                        'tipo_material'      => 'Revista',
                        'fecha_registro'     => $fecha_sql,
                        'folio_adquisicion'  => $folio_con_prefijo,
                        'clasificacion_lomo' => $folio_con_prefijo, 
                        'titulo'             => trim($datos[2] ?? ''),
                        'autor'              => trim($datos[3] ?? ''),
                        'issn'               => (trim($datos[4] ?? '') === 'null') ? null : trim($datos[4] ?? ''),
                        'isbn'               => (trim($datos[5] ?? '') === 'null') ? null : trim($datos[5] ?? ''),
                        'anio_publicacion'   => trim($datos[6] ?? ''),
                        'volumen'            => trim($datos[7] ?? ''),
                        'tomo'               => trim($datos[8] ?? ''),
                        'numero_revista'     => trim($datos[9] ?? ''),
                        'serie'              => trim($datos[10] ?? ''),
                        'pais'               => trim($datos[11] ?? ''),
                        'estado_publicacion' => trim($datos[12] ?? ''),
                        'nota_contenido'     => trim($datos[13] ?? ''),
                        'estado_conservacion'=> trim($datos[14] ?? ''),
                        'ejemplares'         => (int)(trim($datos[15] ?? '1')),
                        'observaciones'      => trim($datos[16] ?? ''),
                        'estado_fisico'      => 'en_estante',
                        'id_ubicacion'       => $id_ubicacion_asignada // <--- Guardamos la ubicación encontrada/creada
                    ];
                    
                    $libroModel->insert($datosInsertar);
                    $registrosInsertados++;
                }
                
                $db->transComplete();
                
                if ($db->transStatus() === FALSE) {
                    return redirect()->back()->with('error', 'Error al importar. Verifica que el archivo no contenga errores.');
                }
                
                return redirect()->to(base_url('/'))->with('success', "¡Éxito! Se importaron {$registrosInsertados} revistas con sus ubicaciones correctamente.");
            }
        }
        
        return view('header') 
             . view('admin_importar_csv') 
             . view('footer');
    }
    
}