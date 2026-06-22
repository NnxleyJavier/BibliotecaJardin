<?php
namespace App\Controllers;

use App\Models\LibroModel;
use App\Models\UbicacionModel;

class Mapa extends BaseController
{
    public function index()
    {
        // Carga la vista del mapa interactivo
        return view('header')
             . view('mapa_biblioteca')
             . view('footer');
    }

    public function buscar()
    {
        $busqueda = $this->request->getGet('q');
        
        if (empty($busqueda)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Término de búsqueda vacío']);
        }

        $libroModel = new LibroModel();
        
        // Buscar el libro por título o autor (búsqueda flexible)
        $libros = $libroModel->select('libros.titulo, libros.autor, ubicaciones.codigo_librero, ubicaciones.fila')
                             ->join('ubicaciones', 'ubicaciones.id_ubicacion = libros.id_ubicacion')
                             ->groupStart()
                                ->like('libros.titulo', $busqueda)
                                ->orLike('libros.autor', $busqueda)
                             ->groupEnd()
                             ->findAll(10); // Límite de 10 resultados para no saturar

        if (empty($libros)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No se encontraron libros con ese término.']);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $libros
        ]);
    }
}
