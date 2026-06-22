<?php
namespace App\Models;
use CodeIgniter\Model;

class UbicacionModel extends Model
{
    protected $table = 'ubicaciones';
    protected $primaryKey = 'id_ubicacion';
    protected $allowedFields = ['codigo_librero', 'fila', 'capacidad_estimada', 'estado'];

    /**
     * Busca el ID real en la base de datos cruzando la Fila y el Número de Librero
     */
    public function obtenerIdPorFilaYEstante($fila, $numero_librero)
    {
        $ubicacion = $this->where('fila', $fila)
                          ->where('codigo_librero', $numero_librero)
                          ->first();
                          
        // Retorna el ID si lo encuentra, o null si el estante no existe
        return $ubicacion ? $ubicacion['id_ubicacion'] : null;
    }
}