<?php
namespace App\Models;
use CodeIgniter\Model;

class FichaMovimientoModel extends Model
{
    protected $table = 'fichas_movimiento';
    protected $primaryKey = 'id_ficha';
    protected $allowedFields = [
        'id_libro', 'id_lector', 'tipo_movimiento', 'estado_ficha', 
        'fecha_solicitud', 'fecha_devolucion_esperada', 'fecha_devolucion_real', 'procesada_admin'
    ];

    /**
     * Procesa la transacción completa para registrar una ficha de préstamo interno
     */
    public function registrarFichaCompleta(array $datosPost): bool
    {
        // Instanciamos los otros modelos necesarios
        $lectorModel   = new LectorModel();
        $libroModel    = new LibroModel();
        $tematicaModel = new TematicaSugeridaModel();

        // Iniciamos la transacción
        $this->db->transStart();

        // --- A. GUARDAR EL LECTOR ---
        $datosLector = [
            'nombre_completo'   => $datosPost['nombre_lector'],
            'telefono'          => $datosPost['telefono'],
            'pais'              => $datosPost['pais'],
            'estado'            => $datosPost['estado'],
            'ocupacion'         => $datosPost['ocupacion'] ?? null,
            'institucion'       => $datosPost['institucion'] ?? null,
            'acepta_privacidad' => isset($datosPost['privacidad']) ? 1 : 0
        ];
        $lectorModel->insert($datosLector);
        $id_lector = $lectorModel->getInsertID();

        // --- B. VERIFICAR/GUARDAR EL LIBRO ---
       // 1. Ahora leemos el nuevo campo 'folio_adquisicion' que viene del formulario
   $folio = trim($datosPost['folio_adquisicion']);
        $libroExistente = $libroModel->where('folio_adquisicion', $folio)->first();

        if ($libroExistente) {
            $id_libro = $libroExistente['id_libro'];
            $libroModel->update($id_libro, ['estado_fisico' => 'en_mesa']);
        } else {
            $datosLibro = [
                'folio_adquisicion'  => $folio,
                'clasificacion_lomo' => trim($datosPost['clasificacion_lomo']), // <-- Guardamos la del usuario
                'titulo'             => trim($datosPost['titulo']),
                'autor'              => trim($datosPost['autor']),
                'volumen'            => trim($datosPost['volumen']),
                'anio_publicacion'   => trim($datosPost['anio']),
                'estado_fisico'      => 'en_mesa',
                'datos_completos'    => 0
            ];
            $libroModel->insert($datosLibro);
            $id_libro = $libroModel->getInsertID();
        }

        // --- C. GUARDAR LA FICHA DE MOVIMIENTO ---
        $datosFicha = [
            'id_libro'  => $id_libro,
            'id_lector' => $id_lector,
        ];
        // Usamos $this porque ya estamos dentro del modelo FichaMovimientoModel
        $this->insert($datosFicha);
        $id_ficha = $this->getInsertID();

        // --- D. PROCESAR Y GUARDAR LAS TEMÁTICAS SUGERIDAS ---
        if (!empty($datosPost['tematica_usuario'])) {
            $etiquetas = explode(',', $datosPost['tematica_usuario']);
            
            foreach ($etiquetas as $etiqueta) {
                $etiquetaLimpia = trim($etiqueta);
                if (!empty($etiquetaLimpia)) {
                    $tematicaModel->insert([
                        'id_libro' => $id_libro,
                        'id_ficha' => $id_ficha,
                        'etiqueta' => $etiquetaLimpia
                    ]);
                }
            }
        }

        // Completamos la transacción
        $this->db->transComplete();

        // Retorna true si todo salió bien, false si algo falló
        return $this->db->transStatus();
    }
   /**
     * Obtiene las fichas que el admin aún no ha procesado para mostrarlas en la tabla.
     * Une las tablas de libros, lectores y agrupa las temáticas.
     */
    public function obtenerFichasPendientes()
    {
      $builder = $this->db->table($this->table . ' f');
        
        // Seleccionamos tanto el folio como la clasificación lomo
        $builder->select('f.id_ficha, f.fecha_solicitud, l.id_libro, l.titulo, l.autor, l.volumen, l.clasificacion_lomo, l.folio_adquisicion, lec.nombre_completo, lec.tipo_lector, GROUP_CONCAT(t.etiqueta SEPARATOR ", ") as tematicas');
        
        $builder->join('libros l', 'l.id_libro = f.id_libro');
        $builder->join('lectores lec', 'lec.id_lector = f.id_lector');
        $builder->join('tematicas_sugeridas t', 't.id_ficha = f.id_ficha', 'left');
        
        $builder->where('f.procesada_admin', 0);
        $builder->groupBy('f.id_ficha');
        $builder->orderBy('f.fecha_solicitud', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Transacción para procesar la ficha desde el panel de admin
     */
    public function procesarFichaAdmin(array $datosPost): bool
    {
        $this->db->transStart();

        $id_ficha           = $datosPost['id_ficha'];
        $tematicasAprobadas = $datosPost['tematicas_aprobadas'] ?? '';

        // 1. Obtener a qué libro pertenece esta ficha para saber qué ID actualizar
        $ficha = $this->find($id_ficha);
        if (!$ficha) {
            return false;
        }
        $id_libro = $ficha['id_libro'];

        // CORRECCIÓN 1: Convertir la Fila y el Librero elegidos por el admin en un id_ubicacion real
        $id_ubicacion = $this->obtenerOcrearUbicacion($datosPost['fila_ubicacion'], $datosPost['numero_librero']);

        // 2. Limpiar y preparar todos los datos corregidos por el Administrador
        $folio_corregido         = trim($datosPost['folio_adquisicion']);
        $titulo_corregido        = trim($datosPost['titulo_libro']);
        $autor_corregido         = trim($datosPost['autor_libro']);
        $volumen_corregido       = trim($datosPost['volumen_libro']);
        $clasificacion_corregida = trim($datosPost['clasificacion_lomo']);

        // Actualizar la tabla de libros
        $this->db->table('libros')->where('id_libro', $id_libro)->update([
            'folio_adquisicion'  => $folio_corregido,         // Guarda el folio validado de 6 dígitos
            'clasificacion_lomo' => $clasificacion_corregida, // <-- CORRECCIÓN 2: ¡AQUÍ YA SE GUARDA EL LOMO!
            'titulo'             => $titulo_corregido,
            'autor'              => $autor_corregido,
            'volumen'            => $volumen_corregido,
            'id_ubicacion'       => $id_ubicacion,            // El ID que generamos en el paso anterior
            'estado_fisico'      => 'en_estante',             // El libro vuelve a estar disponible para su consulta
            'datos_completos'    => 1                         // Marcamos que ya fue auditado por el personal
        ]);

        // 3. Actualizar la Ficha (La marcamos como procesada y completada)
        $this->update($id_ficha, [
            'procesada_admin'       => 1,
            'estado_ficha'          => 'completada',
            'fecha_devolucion_real' => date('Y-m-d H:i:s')    // Queda registrado el momento exacto del acomodo
        ]);

        // 4. Procesar las Temáticas corregidas (Moderación de etiquetas)
        // Eliminamos las sugerencias preliminares para evitar duplicados o basura en la BD
        $this->db->table('tematicas_sugeridas')->where('id_ficha', $id_ficha)->delete();
        
        if (!empty($tematicasAprobadas)) {
            $etiquetas = explode(',', $tematicasAprobadas);
            $datosTematicas = [];
            
            foreach ($etiquetas as $etiqueta) {
                $etiquetaLimpia = trim($etiqueta);
                if (!empty($etiquetaLimpia)) {
                    $datosTematicas[] = [
                        'id_libro'          => $id_libro,
                        'id_ficha'          => $id_ficha,
                        'etiqueta'          => $etiquetaLimpia,
                        'estado_moderacion' => 'aprobada'     // Se convierten en palabras clave oficiales de consulta
                    ];
                }
            }
            
            // Si el administrador dejó etiquetas válidas, las insertamos en lote
            if (count($datosTematicas) > 0) {
                $this->db->table('tematicas_sugeridas')->insertBatch($datosTematicas);
            }
        }

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    /**
     * Obtiene el historial de fichas completadas. 
     * Recibe fechas opcionales para el filtro.
     */
    public function obtenerFichasCompletadas($fechaInicio = null, $fechaFin = null)
    {
        $builder = $this->db->table($this->table . ' f');
        $builder->select('f.id_ficha, f.fecha_solicitud, f.fecha_devolucion_real, l.titulo, l.clasificacion_lomo, lec.nombre_completo');
        $builder->join('libros l', 'l.id_libro = f.id_libro');
        $builder->join('lectores lec', 'lec.id_lector = f.id_lector');
        
        $builder->where('f.estado_ficha', 'completada');

        // Aplicamos el filtro de fechas si el admin lo solicitó
        if ($fechaInicio && $fechaFin) {
            // Aseguramos que tome todo el día final (hasta las 23:59:59)
            $builder->where('f.fecha_solicitud >=', $fechaInicio . ' 00:00:00');
            $builder->where('f.fecha_solicitud <=', $fechaFin . ' 23:59:59');
        }

        $builder->orderBy('f.fecha_devolucion_real', 'DESC'); // Las recién acomodadas primero
        
        return $builder->get()->getResultArray();
    }

    /**
     * Obtiene todos los detalles de una ficha específica para armar el PDF
     */
    public function obtenerDetallesFichaParaPDF($id_ficha)
    {
        $builder = $this->db->table($this->table . ' f');
        $builder->select('f.*, l.titulo, l.autor, l.clasificacion_lomo, l.volumen, l.anio_publicacion, 
                          lec.nombre_completo, lec.ocupacion, lec.institucion, lec.pais, lec.estado as estado_lector, lec.telefono,
                          u.codigo_librero, u.fila, GROUP_CONCAT(t.etiqueta SEPARATOR ", ") as tematicas');
        $builder->join('libros l', 'l.id_libro = f.id_libro');
        $builder->join('lectores lec', 'lec.id_lector = f.id_lector');
        $builder->join('ubicaciones u', 'u.id_ubicacion = l.id_ubicacion', 'left');
        $builder->join('tematicas_sugeridas t', 't.id_ficha = f.id_ficha', 'left');
        
        $builder->where('f.id_ficha', $id_ficha);
        $builder->groupBy('f.id_ficha');
        
        return $builder->get()->getRowArray(); // getRowArray porque es solo un registro
    }
    
    /**
     * Obtiene los detalles de múltiples fichas para la impresión por lote
     */
    public function obtenerDetallesFichasPorLote(array $ids)
    {
        $builder = $this->db->table($this->table . ' f');
        $builder->select('f.*, l.titulo, l.autor, l.clasificacion_lomo, l.volumen, l.anio_publicacion, 
                          lec.nombre_completo, lec.ocupacion, lec.institucion, lec.pais, lec.estado as estado_lector, lec.telefono,
                          u.codigo_librero, u.fila, GROUP_CONCAT(t.etiqueta SEPARATOR ", ") as tematicas');
        $builder->join('libros l', 'l.id_libro = f.id_libro');
        $builder->join('lectores lec', 'lec.id_lector = f.id_lector');
        $builder->join('ubicaciones u', 'u.id_ubicacion = l.id_ubicacion', 'left');
        $builder->join('tematicas_sugeridas t', 't.id_ficha = f.id_ficha', 'left');
        
        $builder->whereIn('f.id_ficha', $ids); // Busca todos los IDs seleccionados
        $builder->groupBy('f.id_ficha');
        
        return $builder->get()->getResultArray(); // Retorna múltiples resultados
    }

    /**
     * Obtiene el historial de fichas completadas con Paginación.
     */
    public function obtenerFichasCompletadasPaginadas($fechaInicio = null, $fechaFin = null, $porPagina = 20)
    {
        // Al usar $this->select en lugar de $this->db->table, activamos la paginación nativa del Modelo
        $this->select('fichas_movimiento.id_ficha, fichas_movimiento.fecha_solicitud, fichas_movimiento.fecha_devolucion_real, libros.titulo, libros.clasificacion_lomo, lectores.nombre_completo');
        $this->join('libros', 'libros.id_libro = fichas_movimiento.id_libro');
        $this->join('lectores', 'lectores.id_lector = fichas_movimiento.id_lector');
        
        $this->where('fichas_movimiento.estado_ficha', 'completada');

        // Aplicamos el filtro de fechas si existe
        if ($fechaInicio && $fechaFin) {
            $this->where('fichas_movimiento.fecha_solicitud >=', $fechaInicio . ' 00:00:00');
            $this->where('fichas_movimiento.fecha_solicitud <=', $fechaFin . ' 23:59:59');
        }

        $this->orderBy('fichas_movimiento.fecha_devolucion_real', 'DESC');
        
        // paginate() hace la magia: divide los resultados y prepara los botones
        return $this->paginate($porPagina);
    }
    /**
     * Busca una ubicación física por fila y número de librero.
     * Si ya existe en la base de datos, retorna su ID. Si no existe, la crea y retorna el nuevo ID.
     */
/**
     * Busca una ubicación física por fila y número de librero.
     * Si ya existe en la base de datos, retorna su ID. Si no existe, la crea y retorna el nuevo ID.
     */
    private function obtenerOcrearUbicacion(string $fila, string $librero): int
    {
        $builder = $this->db->table('ubicaciones');
        
        // ¡Nombres exactos de tu base de datos!
        $columna_fila    = 'fila';
        $columna_librero = 'codigo_librero'; // <--- ESTA ERA LA CAUSA DEL ERROR

        // Realizamos la consulta
        $consulta = $builder->where([
            $columna_fila    => trim($fila),
            $columna_librero => trim($librero)
        ])->get();

        // Verificamos si la consulta falló por algún otro motivo técnico
        if ($consulta === false) {
            log_message('error', 'Error en BD Ubicaciones.');
            return 0; 
        }

        // Extraemos el resultado
        $registro = $consulta->getRowArray();

        // Si la ubicación ya existe, devolvemos su ID numérico
        if ($registro) {
            return (int) $registro['id_ubicacion'];
        }

        // Si es una ubicación nueva que no se había usado, la registramos
        $builder->insert([
            $columna_fila    => trim($fila),
            $columna_librero => trim($librero)
        ]);

        // Retornamos el ID recién creado
        return (int) $this->db->insertID();
    }
}