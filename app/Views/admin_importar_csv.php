<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Importar Revistas (CSV)</h2>
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('/admin/importar_revistas') ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Selecciona el archivo CSV</label>
                <input type="file" name="archivo_csv" accept=".csv" required class="w-full border p-2 rounded">
                <p class="text-sm text-gray-500 mt-2">Guarda el archivo de Excel como "CSV delimitado por comas". El separador interno debe ser punto y coma (;).</p>
            </div>
            
            <button type="submit" class="bg-jardin hover:bg-green-800 text-white font-bold py-2 px-4 rounded shadow transition">
                Subir e Importar
            </button>
        </form>
    </div>
</div>