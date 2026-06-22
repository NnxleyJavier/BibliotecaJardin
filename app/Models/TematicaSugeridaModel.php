<?php
namespace App\Models;
use CodeIgniter\Model;

class TematicaSugeridaModel extends Model
{
    protected $table = 'tematicas_sugeridas';
    protected $primaryKey = 'id_tematica';
    protected $allowedFields = [
        'id_libro', 'id_ficha', 'etiqueta', 'estado_moderacion'
    ];
}