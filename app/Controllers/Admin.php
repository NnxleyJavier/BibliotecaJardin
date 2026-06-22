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

        $data = [
            // Llamamos a la nueva función paginada (ej. 20 registros por página)
            'fichas_completadas' => $fichaModel->obtenerFichasCompletadasPaginadas($fechaInicio, $fechaFin, 20),
            // Obtenemos los botones generados por CodeIgniter
            'pager'              => $fichaModel->pager,
            'fecha_inicio'       => $fechaInicio,
            'fecha_fin'          => $fechaFin
        ];
        
             // Carga la vista del menú principal del administrador
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
}