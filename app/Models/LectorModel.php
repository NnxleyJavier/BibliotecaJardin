<?php
namespace App\Models;
use CodeIgniter\Model;

class LectorModel extends Model
{
    protected $table = 'lectores';
    protected $primaryKey = 'id_lector';
    protected $allowedFields = [
        'nombre_completo', 'tipo_lector', 'telefono', 'pais', 
        'estado', 'ocupacion', 'institucion', 'acepta_privacidad'
    ];
}