<?php
namespace App\Models;
use CodeIgniter\Model;

class LibroModel extends Model
{
    protected $table = 'libros';
    protected $primaryKey = 'id_libro';
    
    // ¡AQUÍ AGREGAMOS EL FOLIO DE ADQUISICIÓN!
  protected $allowedFields = [
        'folio_adquisicion', 'clasificacion_lomo', 'titulo', 'autor', 'volumen', 
        'anio_publicacion', 'id_ubicacion', 'estado_fisico', 'datos_completos',
        'tipo_material', 'fecha_registro', 'issn', 'isbn', 'tomo', 
        'numero_revista', 'serie', 'pais', 'estado_publicacion', 
        'nota_contenido', 'estado_conservacion', 'ejemplares', 'observaciones'
    ];
}