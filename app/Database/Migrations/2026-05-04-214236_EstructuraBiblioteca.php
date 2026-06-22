<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EstructuraBiblioteca extends Migration
{
    public function up()
    {
        // 1. Tabla de Ubicaciones
        $this->forge->addField([
            'id_ubicacion'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'codigo_librero'     => ['type' => 'VARCHAR', 'constraint' => 10],
            'fila'               => ['type' => 'VARCHAR', 'constraint' => 10],
            'capacidad_estimada' => ['type' => 'INT', 'constraint' => 11, 'default' => 50],
            'estado'             => ['type' => 'ENUM', 'constraint' => ['activo', 'inactivo'], 'default' => 'activo'],
        ]);
        $this->forge->addKey('id_ubicacion', true);
        $this->forge->createTable('ubicaciones', true);

        // 2. Tabla de Lectores
        $this->forge->addField([
            'id_lector'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nombre_completo'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'tipo_lector'       => ['type' => 'ENUM', 'constraint' => ['publico_general', 'colaborador_instituto'], 'default' => 'publico_general'],
            'telefono'          => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'pais'              => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'estado'            => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'ocupacion'         => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'institucion'       => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'acepta_privacidad' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'fecha_registro'    => ['type' => 'DATETIME', 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id_lector', true);
        $this->forge->createTable('lectores', true);

        // 3. Tabla de Libros
        $this->forge->addField([
            'id_libro'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'clasificacion_lomo' => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'titulo'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'autor'              => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'volumen'            => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'anio_publicacion'   => ['type' => 'INT', 'constraint' => 4, 'null' => true],
            'id_ubicacion'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'estado_fisico'      => ['type' => 'ENUM', 'constraint' => ['en_estante', 'en_mesa', 'prestado_colaborador', 'extraviado'], 'default' => 'en_mesa'],
            'datos_completos'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
        ]);
        $this->forge->addKey('id_libro', true);
        $this->forge->addForeignKey('id_ubicacion', 'ubicaciones', 'id_ubicacion', 'SET NULL', 'CASCADE');
        $this->forge->createTable('libros', true);

        // 4. Tabla de Fichas Movimiento
        $this->forge->addField([
            'id_ficha'                  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_libro'                  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_lector'                 => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tipo_movimiento'           => ['type' => 'ENUM', 'constraint' => ['consulta_interna', 'prestamo_externo'], 'default' => 'consulta_interna'],
            'estado_ficha'              => ['type' => 'ENUM', 'constraint' => ['activa', 'esperando_acomodo', 'completada'], 'default' => 'activa'],
            'fecha_solicitud'           => ['type' => 'DATETIME', 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'fecha_devolucion_esperada' => ['type' => 'DATETIME', 'null' => true],
            'fecha_devolucion_real'     => ['type' => 'DATETIME', 'null' => true],
            'procesada_admin'           => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
        ]);
        $this->forge->addKey('id_ficha', true);
        $this->forge->addForeignKey('id_libro', 'libros', 'id_libro', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_lector', 'lectores', 'id_lector', 'CASCADE', 'CASCADE');
        $this->forge->createTable('fichas_movimiento', true);

        // 5. Tabla de Temáticas Sugeridas
        $this->forge->addField([
            'id_tematica'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_libro'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_ficha'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'etiqueta'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'estado_moderacion' => ['type' => 'ENUM', 'constraint' => ['pendiente', 'aprobada', 'rechazada'], 'default' => 'pendiente'],
            'fecha_sugerencia'  => ['type' => 'DATETIME', 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id_tematica', true);
        $this->forge->addForeignKey('id_libro', 'libros', 'id_libro', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_ficha', 'fichas_movimiento', 'id_ficha', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tematicas_sugeridas', true);
    }

    public function down()
    {
        // Se eliminan en orden inverso para no romper las restricciones de llaves foráneas
        $this->db->disableForeignKeyChecks();
        
        $this->forge->dropTable('tematicas_sugeridas', true);
        $this->forge->dropTable('fichas_movimiento', true);
        $this->forge->dropTable('libros', true);
        $this->forge->dropTable('lectores', true);
        $this->forge->dropTable('ubicaciones', true);
        
        $this->db->enableForeignKeyChecks();
    }
}