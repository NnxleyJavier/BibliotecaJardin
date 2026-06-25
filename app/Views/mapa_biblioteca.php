<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

    <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-800">Mapa de la Biblioteca</h2>
            <p class="mt-2 text-gray-600">Busca un libro y encuentra su ubicación en el croquis.</p>
        </div>

        <div class="w-full md:w-1/3">
            <div class="relative">
                <input type="text" id="buscador" placeholder="Buscar por título o autor..." class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 shadow-sm">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div id="resultados" class="absolute z-10 w-full bg-white rounded-lg shadow-xl mt-1 max-h-60 overflow-y-auto hidden border border-gray-100">
                <!-- Resultados de búsqueda se inyectan aquí -->
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 overflow-x-auto border border-gray-100 relative">
        <!-- Contenedor del Mapa SVG -->
        <div class="min-w-[800px] flex justify-center">


        <svg id="plano-biblioteca" viewBox="0 0 1000 1100" class="w-full h-auto max-w-4xl mx-auto" style="background-color: #f8fafc; border-radius: 8px;">
    <defs>
        <filter id="shadow" x="-10%" y="-10%" width="120%" height="120%">
            <feDropShadow dx="2" dy="2" stdDeviation="2" flood-opacity="0.1" />
        </filter>
        <style>
            .librero { fill: #d4a373; stroke: #8b5a2b; stroke-width: 2; transition: all 0.3s ease; cursor: pointer; }
            .librero:hover { fill: #faedcd; }
            .librero.highlight { fill: #ef4444; stroke: #991b1b; animation: pulse 1.5s infinite; }
            @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.02); } 100% { transform: scale(1); } }
            .pared { stroke: #94a3b8; stroke-width: 8; stroke-linecap: round; fill: none; }
            .puerta { stroke: #cbd5e1; stroke-width: 6; stroke-dasharray: 10, 10; fill: none; }
            .ventana { stroke: #38bdf8; stroke-width: 6; fill: none; }
            .texto-muro { font-family: sans-serif; font-size: 14px; fill: #64748b; font-weight: bold; }
        </style>
    </defs>

    <line x1="295" y1="100" x2="295" y2="560" class="pared" />
    <line x1="295" y1="700" x2="295" y2="985" class="pared" />
    <line x1="295" y1="560" x2="295" y2="700" class="puerta" />
    <text x="270" y="630" class="texto-muro" transform="rotate(-90, 270, 630)">PUERTA</text>

    <line x1="295" y1="100" x2="711" y2="100" class="pared" /> <line x1="711" y1="100" x2="711" y2="985" class="pared" /> <line x1="295" y1="985" x2="711" y2="985" class="pared" /> <text x="250" y="330" class="texto-muro" transform="rotate(-90, 250, 330)">PARED IZQUIERDA</text>
    <text x="503" y="80" class="texto-muro" text-anchor="middle">PARED DE ENFRENTE</text>
    <text x="750" y="525" class="texto-muro" transform="rotate(90, 750, 525)">PARED DERECHA</text>
    <text x="503" y="1025" class="texto-muro" text-anchor="middle">PARED DE ATRÁS</text>

    <g id="pared-izquierda-arriba">
        <rect x="295" y="140" width="40" height="35" class="librero" data-librero="IZQ-1" /> <rect x="295" y="175" width="40" height="35" class="librero" data-librero="IZQ-2" /> <rect x="295" y="210" width="40" height="35" class="librero" data-librero="IZQ-3" /> <rect x="295" y="245" width="40" height="35" class="librero" data-librero="IZQ-4" /> <rect x="295" y="280" width="40" height="35" class="librero" data-librero="IZQ-5" /> <rect x="295" y="315" width="40" height="35" class="librero" data-librero="IZQ-6" /> <rect x="295" y="350" width="40" height="35" class="librero" data-librero="IZQ-7" /> <rect x="295" y="385" width="40" height="35" class="librero" data-librero="IZQ-8" /> <rect x="295" y="420" width="40" height="35" class="librero" data-librero="IZQ-9" /> <rect x="295" y="455" width="40" height="35" class="librero" data-librero="IZQ-10" /> <rect x="295" y="490" width="40" height="35" class="librero" data-librero="IZQ-11" /> <rect x="295" y="525" width="40" height="35" class="librero" data-librero="IZQ-12" /> </g>

    <g id="pared-izquierda-abajo">
        <rect x="295" y="700" width="40" height="35" class="librero" data-librero="P-BD" />
        <rect x="295" y="735" width="40" height="35" class="librero" data-librero="P-BC" />
        <rect x="295" y="770" width="40" height="35" class="librero" data-librero="P-BB" />
        <rect x="295" y="805" width="40" height="35" class="librero" data-librero="P-BA" />
        
        <line x1="295" y1="840" x2="295" y2="910" class="ventana" />
        <rect x="295" y="840" width="20" height="35" class="librero" data-librero="P-AZ" />
        <rect x="295" y="875" width="20" height="35" class="librero" data-librero="P-AY" />
        
        <rect x="295" y="910" width="40" height="35" class="librero" data-librero="P-AX" />
    </g>

    <g id="pared-frontal">
        <rect x="335" y="100" width="42" height="40" class="librero" data-librero="FR-1" /> <rect x="377" y="100" width="42" height="40" class="librero" data-librero="FR-2" /> <rect x="419" y="100" width="42" height="40" class="librero" data-librero="FR-3" /> <rect x="461" y="100" width="42" height="40" class="librero" data-librero="FR-4" /> <rect x="503" y="100" width="42" height="40" class="librero" data-librero="FR-5" /> <rect x="545" y="100" width="42" height="40" class="librero" data-librero="FR-6" /> <rect x="587" y="100" width="42" height="40" class="librero" data-librero="FR-7" /> <rect x="629" y="100" width="42" height="40" class="librero" data-librero="FR-8" /> </g>

    <g id="pared-atras">
        <rect x="623" y="945" width="48" height="40" class="librero" data-librero="P-AQ" />
        <rect x="575" y="945" width="48" height="40" class="librero" data-librero="P-AR" />
        <rect x="527" y="945" width="48" height="40" class="librero" data-librero="P-AS" />
        <rect x="479" y="945" width="48" height="40" class="librero" data-librero="P-AT" />
        <rect x="431" y="945" width="48" height="40" class="librero" data-librero="P-AU" />
        <rect x="383" y="945" width="48" height="40" class="librero" data-librero="P-AV" />
        <rect x="335" y="945" width="48" height="40" class="librero" data-librero="P-AW" />
    </g>

    <g id="pared-derecha">
        <rect x="671" y="140" width="40" height="35" class="librero" data-librero="DER-1" /> <rect x="671" y="175" width="40" height="35" class="librero" data-librero="DER-2" /> <rect x="671" y="210" width="40" height="35" class="librero" data-librero="DER-3" /> <rect x="671" y="245" width="40" height="35" class="librero" data-librero="DER-4" /> <rect x="671" y="280" width="40" height="35" class="librero" data-librero="DER-5" /> <rect x="671" y="315" width="40" height="35" class="librero" data-librero="DER-6" /> <rect x="671" y="350" width="40" height="35" class="librero" data-librero="DER-7" /> <rect x="671" y="385" width="40" height="35" class="librero" data-librero="DER-8" /> <rect x="671" y="420" width="40" height="35" class="librero" data-librero="DER-9" /> <rect x="671" y="455" width="40" height="35" class="librero" data-librero="DER-10" /> <rect x="671" y="490" width="40" height="35" class="librero" data-librero="DER-11" /> <rect x="671" y="525" width="40" height="35" class="librero" data-librero="DER-12" /> <rect x="671" y="560" width="40" height="35" class="librero" data-librero="DER-13" /> <rect x="671" y="595" width="40" height="35" class="librero" data-librero="DER-14" /> <line x1="711" y1="630" x2="711" y2="700" class="ventana" />
        <rect x="691" y="630" width="20" height="35" class="librero" data-librero="P-AI" />
        <rect x="691" y="665" width="20" height="35" class="librero" data-librero="P-AJ" />
        
        <rect x="671" y="700" width="40" height="35" class="librero" data-librero="P-AK" />
        <rect x="671" y="735" width="40" height="35" class="librero" data-librero="P-AL" />
        <rect x="671" y="770" width="40" height="35" class="librero" data-librero="P-AM" />
        <rect x="671" y="805" width="40" height="35" class="librero" data-librero="P-AN" />
        
        <line x1="711" y1="840" x2="711" y2="910" class="ventana" />
        <rect x="691" y="840" width="20" height="35" class="librero" data-librero="P-AÑ" />
        <rect x="691" y="875" width="20" height="35" class="librero" data-librero="P-AO" />
        
        <rect x="671" y="910" width="40" height="35" class="librero" data-librero="P-AP" />
    </g>

    <g id="mesas" filter="url(#shadow)">
        <rect x="390" y="180" width="220" height="130" rx="8" fill="#e2e8f0" stroke="#cbd5e1" stroke-width="2" />
        <rect x="390" y="340" width="220" height="130" rx="8" fill="#e2e8f0" stroke="#cbd5e1" stroke-width="2" />
    </g>
    <text x="500" y="245" class="texto-muro" text-anchor="middle">Mesa Lectura</text>
    <text x="500" y="405" class="texto-muro" text-anchor="middle">Mesa Lectura</text>
</svg>


        </div>

        <!-- Tarjeta de Información flotante -->
        <div id="info-card" class="absolute bottom-6 right-6 bg-white p-4 rounded-xl shadow-xl border border-gray-200 w-80 hidden">
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-bold text-gray-800 text-lg">Libro Encontrado</h3>
                <button onclick="cerrarInfo()" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg></button>
            </div>
            <p id="info-titulo" class="text-green-700 font-semibold mb-1"></p>
            <p id="info-autor" class="text-gray-600 text-sm mb-3"></p>
            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Ubicación Física</p>
                <p class="font-medium text-gray-800">
                    Librero: <span id="info-librero" class="text-red-600 font-bold"></span><br>
                    Fila: <span id="info-fila" class="font-semibold"></span>
                </p>
            </div>
        </div>

    </div>
</div>

<!-- ============================================== -->
<!-- SCRIPT DE MAPEO Y BÚSQUEDA -->
<!-- ============================================== -->
<script>
    // ==========================================
    // CONFIGURACIÓN DE MAPEO
    // Aquí puedes enlazar los "códigos de librero" de tu base de datos 
    // con los IDs (data-librero) del mapa SVG.
    // Ejemplo: Si en la DB el librero es "AB", pon: "AB": "IZQ-1"
    // ==========================================

    // Aquí debes completar tu propio mapeo conectando la DB con el SVG:
    // "CODIGO_BD": "ID_SVG"
const MAPEO_LIBREROS = {
    // --- PARED IZQUIERDA (Mitad Superior) ---
    "A": "IZQ-12", "B": "IZQ-11", "C": "IZQ-10", "D": "IZQ-9",
    "E": "IZQ-8", "F": "IZQ-7", "G": "IZQ-6", "H": "IZQ-5",
    "I": "IZQ-4", "J": "IZQ-3", "K": "IZQ-2", "L": "IZQ-1",

    // --- PARED DE ENFRENTE ---
    "M": "FR-1", "N": "FR-2", "O": "FR-3", "P": "FR-4", 
    "Q": "FR-5", "R": "FR-6", "S": "FR-7", "T": "FR-8",

    // --- PARED DERECHA ---
    "U": "DER-1", "V": "DER-2", "W": "DER-3", "X": "DER-4", 
    "Y": "DER-5", "Z": "DER-6", "AA": "DER-7", "AB": "DER-8", 
    "AC": "DER-9", "AD": "DER-10", "AE": "DER-11", "AF": "DER-12", 
    "AG": "DER-13", "AH": "DER-14",
    "AI": "P-AI", "AJ": "P-AJ", "AK": "P-AK", "AL": "P-AL",
    "AM": "P-AM", "AN": "P-AN", "AÑ": "P-AÑ", "AO": "P-AO", "AP": "P-AP",

    // --- PARED DE ATRÁS ---
    "AQ": "P-AQ", "AR": "P-AR", "AS": "P-AS", "AT": "P-AT",
    "AU": "P-AU", "AV": "P-AV", "AW": "P-AW",

    // --- PARED IZQUIERDA (Mitad Inferior) ---
    "AX": "P-AX", "AY": "P-AY", "AZ": "P-AZ", 
    "BA": "P-BA", "BB": "P-BB", "BC": "P-BC", "BD": "P-BD"
};
    const buscador = document.getElementById('buscador');
    const resultadosBox = document.getElementById('resultados');
    const svgMap = document.getElementById('plano-biblioteca');
    const infoCard = document.getElementById('info-card');

    let debounceTimeout = null;

    buscador.addEventListener('input', function(e) {
        const query = e.target.value.trim();

        clearTimeout(debounceTimeout);

        if (query.length < 2) {
            resultadosBox.classList.add('hidden');
            return;
        }

        // Retardo para no saturar el servidor (debounce)
        debounceTimeout = setTimeout(() => {
            fetch(`<?= base_url('/mapa/buscar') ?>?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    resultadosBox.innerHTML = '';

                    if (data.status === 'success') {
                        const ul = document.createElement('ul');
                        ul.className = "py-2";

                        data.data.forEach(libro => {
                            const li = document.createElement('li');
                            li.className = "px-4 py-2 hover:bg-green-50 cursor-pointer border-b border-gray-100 last:border-0";
                            li.innerHTML = `
                                <div class="font-semibold text-gray-800">${libro.titulo}</div>
                                <div class="text-xs text-gray-500">${libro.autor} • Ubicación: ${libro.fila} - ${libro.codigo_librero}</div>
                            `;

                            // Al hacer clic en un resultado
                            li.addEventListener('click', () => {
                                buscador.value = libro.titulo;
                                resultadosBox.classList.add('hidden');
                                iluminarLibrero(libro);
                            });

                            ul.appendChild(li);
                        });
                        resultadosBox.appendChild(ul);
                        resultadosBox.classList.remove('hidden');
                    } else {
                        resultadosBox.innerHTML = `<div class="px-4 py-3 text-sm text-gray-500">${data.message}</div>`;
                        resultadosBox.classList.remove('hidden');
                    }
                })
                .catch(error => console.error('Error:', error));
        }, 300);
    });

    // Ocultar resultados si se hace click fuera
    document.addEventListener('click', function(e) {
        if (!buscador.contains(e.target) && !resultadosBox.contains(e.target)) {
            resultadosBox.classList.add('hidden');
        }
    });

function iluminarLibrero(libro) {
        // 1. Apagar todos los libreros
        document.querySelectorAll('.librero').forEach(el => {
            el.classList.remove('highlight');
        });
        
        // 2. Limpiar cualquier indicador de número previo
        document.querySelectorAll('.indicador-fila').forEach(el => el.remove());

        // Convertir a texto para procesarlos
        const val1 = libro.codigo_librero.toString().trim();
        const val2 = libro.fila.toString().trim();
        
        // Detección inteligente: Averiguar cuál tiene la letra (A, B, AA...) y cuál el número (8, 1...)
        // isNaN (Is Not a Number) devolverá true para las letras
        let letraLibrero = isNaN(val1) ? val1 : val2;
        let numeroColumna = isNaN(val1) ? val2 : val1;

        // Buscar el ID del SVG usando la letra en tu mapa (ej. MAPEO_LIBREROS["A"] -> "IZQ-1")
        let idSvg = MAPEO_LIBREROS[letraLibrero];

        if (!idSvg) {
            idSvg = letraLibrero; // Fallback por si la letra es directamente el ID
        }

        // Buscar el rectángulo correspondiente en el SVG
        const libreroMueble = document.querySelector(`[data-librero="${idSvg}"]`);

        if (libreroMueble) {
            // Animación de iluminar el rectángulo
            libreroMueble.classList.add('highlight');

            // 3. Dibujar el número de columna dentro del SVG
            const svgNS = "http://www.w3.org/2000/svg";
            
            // Leer coordenadas del librero
            const x = parseFloat(libreroMueble.getAttribute('x'));
            const y = parseFloat(libreroMueble.getAttribute('y'));
            const w = parseFloat(libreroMueble.getAttribute('width'));
            const h = parseFloat(libreroMueble.getAttribute('height'));
            
            // Calcular el centro
            const cx = x + (w / 2);
            const cy = y + (h / 2);
            
            // Crear elemento de texto
            const textoNumero = document.createElementNS(svgNS, 'text');
            textoNumero.setAttribute('x', cx);
            textoNumero.setAttribute('y', cy);
            textoNumero.setAttribute('class', 'texto-librero indicador-fila'); 
            
            // Alinear exactamente al centro del punto calculado
            textoNumero.setAttribute('text-anchor', 'middle');
            textoNumero.setAttribute('dominant-baseline', 'middle');
            
            // Estilos para que el número resalte sobre el color de "highlight"
            textoNumero.style.fontSize = "18px"; 
            textoNumero.style.fontWeight = "bold";
            textoNumero.style.fill = "#ffffff"; 
            textoNumero.style.pointerEvents = "none";
            
            // Insertar únicamente el número (Ej: "8")
            textoNumero.textContent = numeroColumna; 
            
            // Agregar el texto al SVG
            libreroMueble.parentNode.appendChild(textoNumero);

            // 4. Mostrar Info Card (asegurándonos de mostrar los datos en orden correcto)
            document.getElementById('info-titulo').textContent = libro.titulo;
            document.getElementById('info-autor').textContent = libro.autor;
            document.getElementById('info-librero').textContent = letraLibrero; 
            document.getElementById('info-fila').textContent = numeroColumna; 
            infoCard.classList.remove('hidden');
        } else {
            alert(`El libro está en el Librero ${letraLibrero} (Columna/Fila ${numeroColumna}), pero el código '${idSvg}' no está dibujado en el SVG.`);
        }
    }

    function cerrarInfo() {
        infoCard.classList.add('hidden');
        
        document.querySelectorAll('.librero').forEach(el => {
            el.classList.remove('highlight');
        });
        
        // [NUEVO] Eliminar el texto de la fila al cerrar la búsqueda
        document.querySelectorAll('.indicador-fila').forEach(el => el.remove());
        
        buscador.value = '';
    }

    // Opcional: Hacer click en los estantes muestra su ID
    document.querySelectorAll('.librero').forEach(el => {
        el.addEventListener('click', function() {
            const id = this.getAttribute('data-librero');
            alert(`Librero SVG ID: ${id}\nAñade este ID en MAPEO_LIBREROS para enlazarlo a tu Base de Datos.`);
        });
    });
</script>