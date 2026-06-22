<?php
namespace App\Controllers;

use App\Models\FichaMovimientoModel;

class Biblioteca extends BaseController
{
    public function index()
    {
        // Recuperamos la lógica de idiomas para que la vista no lance el error de "Undefined variable"
        $data = [
            'idioma_actual' => $this->request->getLocale()
        ];

        // Asegúrate de que esta vista sea la pública que tiene el formulario de idiomas
        return view('Ficha_prestamo', $data); 
    }

    public function guardar_ficha()
    {
        // 1. Validaciones backend (Seguridad adicional con el Folio de Adquisición)
        $reglas = [
            'folio_adquisicion'  => 'required|exact_length[6]|numeric',
            'clasificacion_lomo' => 'required', // <-- Agregamos regla
            'titulo'             => 'required',
            'nombre_lector'      => 'required',
            'telefono'           => 'required|numeric|min_length[10]',
            'privacidad'         => 'required'
        ];

        $mensajes = [
            'folio_adquisicion' => [
                'required'     => 'El Folio de Adquisición es obligatorio.',
                'exact_length' => 'El Folio debe contener exactamente 6 dígitos.',
                'numeric'      => 'El Folio solo puede contener números.'
            ],
            'titulo'        => ['required' => 'El título de la obra es obligatorio.'],
            'nombre_lector' => ['required' => 'Tu nombre completo es obligatorio.'],
            'telefono'      => [
                'required'   => 'El número de teléfono es obligatorio.',
                'numeric'    => 'El teléfono solo debe contener números.',
                'min_length' => 'El teléfono debe tener al menos 10 dígitos.'
            ],
            'privacidad'    => ['required' => 'Debes aceptar el aviso de privacidad.']
        ];

        // Si la validación falla, devolvemos los errores en formato JSON
        if (!$this->validate($reglas, $mensajes)) {
            return $this->response->setJSON([
                'status' => 'error',
                'title'  => 'Faltan datos',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // 2. Si pasa la validación, procedemos a guardar
        $datosPost = $this->request->getPost();
        $fichaModel = new FichaMovimientoModel();

  // IMPLEMENTACIÓN DE TRY...CATCH PARA ATRAPAR EXCEPCIONES DE CI4
        try {
            // Intentamos ejecutar el modelo
            if ($fichaModel->registrarFichaCompleta($datosPost)) {
                // Éxito
                return $this->response->setJSON([
                    'status'  => 'success',
                    'title'   => '¡Registro Exitoso!',
                    'message' => 'Tu ficha de consulta y aportaciones se guardaron correctamente. ¡Gracias por ayudar a la biblioteca!'
                ]);
            } else {
                // Si retorna false de forma silenciosa (raro en CI4, pero posible)
                return $this->response->setJSON([
                    'status'  => 'error',
                    'title'   => 'Transacción Fallida',
                    'message' => 'El modelo devolvió false. Verifica los logs de CI4.'
                ]);
            }
        } catch (\Exception $e) {
            // ¡AQUÍ ATRAPAMOS EL ERROR FATAL DE LA BASE DE DATOS!
            // Extraemos exactamente qué falló, en qué archivo y en qué línea
            return $this->response->setJSON([
                'status'  => 'error',
                'title'   => 'Error CI4 (' . $e->getCode() . ')',
                'message' => 'Error: ' . $e->getMessage() . ' | Archivo: ' . basename($e->getFile()) . ' | Línea: ' . $e->getLine()
            ]);
        }
    }
}