<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Auth routes (Shield las inyecta automáticamente, pero es buena práctica declararlas si customizas)
service('auth')->routes($routes);
// ==========================================
// RUTAS PÚBLICAS (Visitantes del Kiosco)
// ==========================================
$routes->get('/', 'Home::index');
$routes->post('/guardar_ficha', 'Biblioteca::guardar_ficha');


// ==========================================
// RUTAS PRIVADAS (Administración protegida)
// ==========================================
// Al envolverlas en este grupo, Shield exigirá inicio de sesión automático
$routes->group('', ['filter' => 'session'], static function ($routes) {
    
    // Panel central
    $routes->get('/panel', 'Admin::panel');
    
    // Módulo de Fichas Pendientes
    $routes->get('/admin', 'Admin::index');
    $routes->post('/procesar_ficha', 'Admin::procesar_ficha');
    
    // Módulo de Historial e Impresión
    $routes->get('/completadas', 'Admin::completadas');
    $routes->get('/descargar_pdf/(:num)', 'Admin::descargar_pdf/$1');
    $routes->post('/imprimir_lote', 'Admin::imprimir_lote');
    $routes->get('/biblioteca', 'Biblioteca::index');

    // Mapa interactivo
    $routes->get('/mapa', 'Mapa::index');
    $routes->get('/mapa/buscar', 'Mapa::buscar');

    $routes->get('/importar_csv', 'Admin::importar_revistas');

});


$routes->get('idioma/(:any)', 'Home::cambiarIdioma/$1');