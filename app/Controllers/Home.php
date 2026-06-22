<?php

namespace App\Controllers;

class Home extends BaseController
{
   public function index()
    {
        // 1. Verificamos si el usuario ya eligió un idioma, si no, por defecto 'es'
        $idioma = session()->get('idioma') ?? 'es';
        
        // 2. Le decimos a CodeIgniter que establezca este idioma
        $this->request->setLocale($idioma);

        // 3. ¡AQUÍ ESTÁ LA SOLUCIÓN! Empaquetamos la variable en un arreglo
        $data = [
            'idioma_actual' => $idioma
        ];

        // 4. Se la enviamos a la vista como segundo parámetro
        // (Asegúrate de que la ruta de tu vista sea la correcta, ya sea 'biblioteca/ficha_prestamo' o solo 'Ficha_prestamo')
        return view('Ficha_prestamo', $data); 
    }

    // Nueva función para cambiar el idioma haciendo clic en el menú
  public function cambiarIdioma($idioma)
{
    // Validamos que el idioma sea uno de los permitidos para evitar basura en la sesión
    if (in_array($idioma, ['es', 'en', 'pt'])) {
        session()->set('idioma', $idioma);
    }
    
    // Al haber limpiado la $indexPage en el paso 1, 
    // el redirect()->back() te devolverá a la ficha sin el index.php en la URL
    return redirect()->back();
}
}
