<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UbicacionesSeeder extends Seeder
{
    public function run()
    {
        // Todas las filas que pusiste en tu HTML
        $filas = [
            'A','B','C','D','E','F','G','H','I','J','K','L','M',
            'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'AA','AB','AC','AD','AE','AF'
        ];

        $datos = [];

        // Hacemos un loop para combinar cada fila con 10 libreros
        foreach ($filas as $fila) {
            for ($i = 1; $i <= 10; $i++) {
                $datos[] = [
                    'codigo_librero'     => (string)$i,  // Guarda '1', '2', etc.
                    'fila'               => $fila,       // Guarda 'A', 'B', etc.
                    'capacidad_estimada' => 50,          // Valor por defecto
                    'estado'             => 'activo'
                ];
            }
        }

        // insertBatch inserta los 320 registros de un solo golpe (muy optimizado)
        $this->db->table('ubicaciones')->insertBatch($datos);
    }
}