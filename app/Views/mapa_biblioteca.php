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

            <svg id="plano-biblioteca" viewBox="0 0 1000 800" class="w-full h-auto max-w-4xl" style="background-color: #f8fafc; border-radius: 8px;">

                <!-- Definiciones -->
                <defs>
                    <filter id="shadow" x="-10%" y="-10%" width="120%" height="120%">
                        <feDropShadow dx="2" dy="2" stdDeviation="2" flood-opacity="0.1" />
                    </filter>

                    <style>
                        .librero {
                            fill: #d4a373;
                            stroke: #8b5a2b;
                            stroke-width: 2;
                            transition: all 0.3s ease;
                            cursor: pointer;
                        }

                        .librero:hover {
                            fill: #faedcd;
                        }

                        .librero.highlight {
                            fill: #ef4444;
                            stroke: #991b1b;
                            animation: pulse 1.5s infinite;
                        }

                        @keyframes pulse {
                            0% {
                                transform: scale(1);
                            }

                            50% {
                                transform: scale(1.02);
                            }

                            100% {
                                transform: scale(1);
                            }
                        }

                        .pared {
                            stroke: #94a3b8;
                            stroke-width: 8;
                            stroke-linecap: round;
                            fill: none;
                        }

                        .puerta {
                            stroke: #cbd5e1;
                            stroke-width: 6;
                            stroke-dasharray: 10, 10;
                            fill: none;
                        }

                        .ventana {
                            stroke: #38bdf8;
                            stroke-width: 6;
                            fill: none;
                        }

                        .texto-muro {
                            font-family: sans-serif;
                            font-size: 14px;
                            fill: #64748b;
                            font-weight: bold;
                        }

                        .texto-librero {
                            font-family: sans-serif;
                            font-size: 10px;
                            fill: #fff;
                            font-weight: bold;
                            pointer-events: none;
                            text-anchor: middle;
                            dominant-baseline: middle;
                        }
                    </style>
                </defs>

                <!-- Muros perimetrales (Forma de U más cerrada) -->
                <!-- Pared Izquierda -->
                <line x1="100" y1="100" x2="100" y2="700" class="pared" />
                <!-- Pared Frontal (Arriba) -->
                <line x1="100" y1="100" x2="550" y2="100" class="pared" />
                <!-- Pared Derecha -->
                <line x1="550" y1="100" x2="550" y2="700" class="pared" />

                <text x="50" y="400" class="texto-muro" transform="rotate(-90, 50, 400)">PARED IZQUIERDA</text>
                <text x="325" y="70" class="texto-muro" text-anchor="middle">MURO DE ENFRENTE</text>
                <text x="600" y="400" class="texto-muro" transform="rotate(90, 600, 400)">PARED DERECHA</text>

                <!-- =============================== -->
                <!-- PARED IZQUIERDA (x: 105, y: 120 -> 680) -->
                <!-- =============================== -->
                <g id="pared-izquierda">
                    <!-- 2 grandes con 8 -->
                    <rect x="105" y="120" width="45" height="35" class="librero" data-librero="IZQ-1" filter="url(#shadow)" />
                    <rect x="105" y="160" width="45" height="35" class="librero" data-librero="IZQ-2" filter="url(#shadow)" />

                    <!-- 2 chicos con 4 -->
                    <line x1="100" y1="200" x2="100" y2="270" class="ventana" /> <!-- Ventana -->
                    <rect x="105" y="200" width="30" height="35" class="librero" data-librero="IZQ-3" filter="url(#shadow)" />
                    <rect x="105" y="240" width="30" height="35" class="librero" data-librero="IZQ-4" filter="url(#shadow)" />

                    <!-- 4 grandes con 8 -->
                    <rect x="105" y="280" width="45" height="35" class="librero" data-librero="IZQ-5" filter="url(#shadow)" />
                    <rect x="105" y="320" width="45" height="35" class="librero" data-librero="IZQ-6" filter="url(#shadow)" />
                    <rect x="105" y="360" width="45" height="35" class="librero" data-librero="IZQ-7" filter="url(#shadow)" />
                    <rect x="105" y="400" width="45" height="35" class="librero" data-librero="IZQ-8" filter="url(#shadow)" />

                    <!-- 2 chicos con 2 -->
                    <rect x="105" y="440" width="20" height="35" class="librero" data-librero="IZQ-9" filter="url(#shadow)" />
                    <rect x="105" y="480" width="20" height="35" class="librero" data-librero="IZQ-10" filter="url(#shadow)" />

                    <!-- 2 grandes con 8 -->
                    <rect x="105" y="520" width="45" height="35" class="librero" data-librero="IZQ-11" filter="url(#shadow)" />
                    <rect x="105" y="560" width="45" height="35" class="librero" data-librero="IZQ-12" filter="url(#shadow)" />
                </g>

                <!-- =============================== -->
                <!-- MURO DE ENFRENTE (x: 120 -> 510) -->
                <!-- =============================== -->
                <g id="muro-enfrente">
                    <!-- 3 grandes con 8 -->
                    <rect x="150" y="105" width="40" height="45" class="librero" data-librero="FR-1" filter="url(#shadow)" />
                    <rect x="195" y="105" width="40" height="45" class="librero" data-librero="FR-2" filter="url(#shadow)" />
                    <rect x="240" y="105" width="40" height="45" class="librero" data-librero="FR-3" filter="url(#shadow)" />

                    <!-- 2 chicos con 2 (sobre puerta) -->
                    <line x1="285" y1="100" x2="375" y2="100" class="puerta" />
                    <rect x="285" y="105" width="40" height="20" class="librero" data-librero="FR-4" filter="url(#shadow)" />
                    <rect x="330" y="105" width="40" height="20" class="librero" data-librero="FR-5" filter="url(#shadow)" />

                    <!-- 3 grandes con 8 -->
                    <rect x="375" y="105" width="40" height="45" class="librero" data-librero="FR-6" filter="url(#shadow)" />
                    <rect x="420" y="105" width="40" height="45" class="librero" data-librero="FR-7" filter="url(#shadow)" />
                    <rect x="465" y="105" width="40" height="45" class="librero" data-librero="FR-8" filter="url(#shadow)" />

                </g>

                <!-- =============================== -->
                <!-- PARED DERECHA (desplazada a X=550) -->
                <!-- =============================== -->
                <g id="pared-derecha">
                    <!-- 2 grandes con 8 (al inicio) -->
                    <rect x="505" y="120" width="45" height="35" class="librero" data-librero="DER-1" filter="url(#shadow)" />
                    <rect x="505" y="160" width="45" height="35" class="librero" data-librero="DER-2" filter="url(#shadow)" />

                    <!-- 2 chicos con 4 (bajo ventana) -->
                    <line x1="550" y1="200" x2="550" y2="270" class="ventana" />
                    <rect x="520" y="200" width="30" height="35" class="librero" data-librero="DER-3" filter="url(#shadow)" />
                    <rect x="520" y="240" width="30" height="35" class="librero" data-librero="DER-4" filter="url(#shadow)" />

                    <!-- 4 grandes con 8 -->
                    <rect x="505" y="280" width="45" height="35" class="librero" data-librero="DER-5" filter="url(#shadow)" />
                    <rect x="505" y="320" width="45" height="35" class="librero" data-librero="DER-6" filter="url(#shadow)" />
                    <rect x="505" y="360" width="45" height="35" class="librero" data-librero="DER-7" filter="url(#shadow)" />
                    <rect x="505" y="400" width="45" height="35" class="librero" data-librero="DER-8" filter="url(#shadow)" />

                    <!-- 2 chicos con 4 (bajo ventana) -->
                    <line x1="550" y1="440" x2="550" y2="510" class="ventana" />
                    <rect x="520" y="440" width="30" height="35" class="librero" data-librero="DER-9" filter="url(#shadow)" />
                    <rect x="520" y="480" width="30" height="35" class="librero" data-librero="DER-10" filter="url(#shadow)" />

                    <!-- 4 grandes con 8 -->
                    <rect x="505" y="520" width="45" height="35" class="librero" data-librero="DER-11" filter="url(#shadow)" />
                    <rect x="505" y="560" width="45" height="35" class="librero" data-librero="DER-12" filter="url(#shadow)" />
                    <rect x="505" y="600" width="45" height="35" class="librero" data-librero="DER-13" filter="url(#shadow)" />
                    <rect x="505" y="640" width="45" height="35" class="librero" data-librero="DER-14" filter="url(#shadow)" />
                </g>

                <!-- Mesas de lectura en el centro -->
                <rect x="250" y="250" width="80" height="150" rx="10" fill="#e2e8f0" stroke="#cbd5e1" stroke-width="2" />
                <rect x="250" y="450" width="80" height="150" rx="10" fill="#e2e8f0" stroke="#cbd5e1" stroke-width="2" />

                <text x="290" y="325" class="texto-muro" text-anchor="middle" transform="rotate(-90, 290, 325)">Mesa Lectura</text>
                <text x="290" y="525" class="texto-muro" text-anchor="middle" transform="rotate(-90, 290, 525)">Mesa Lectura</text>

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
        // Pared Izquierda
        "A": "IZQ-1",
        "B": "IZQ-2",
        "C": "IZQ-3",
        "D": "IZQ-4",
        "E": "IZQ-5",
        "F": "IZQ-6",
        "G": "IZQ-7",
        "H": "IZQ-8",
        "I": "IZQ-9",
        "J": "IZQ-10",
        "K": "IZQ-11",
        "L": "IZQ-12",

        // Pared enfrente
        "M": "FR-1",
        "N": "FR-2",
        "O": "FR-3",
        "P": "FR-4",
        "Q": "FR-5",
        "R": "FR-6",
        "S": "FR-7",
        "T": "FR-8",
        // pared derecha
        "U": "DER-1",
        "V": "DER-2",
        "W": "DER-3",
        "X": "DER-4",
        "Y": "DER-5",
        "Z": "DER-6",
        "AA": "DER-7",
        "AB": "DER-8",
        "AC": "DER-9",
        "AD": "DER-10",
        "AE": "DER-11",
        "AF": "DER-12",
        "AG": "DER-13",
        "AH": "DER-14",


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

        const codigoDB = libro.codigo_librero;
        let idSvg = MAPEO_LIBREROS[codigoDB];

        // Intento de fallback: Si el código de la BD es exactamente igual a un data-librero
        if (!idSvg) {
            idSvg = codigoDB;
        }

        // Buscar el elemento en el SVG
        const libreroMueble = document.querySelector(`[data-librero="${idSvg}"]`);

        if (libreroMueble) {
            // Animación de iluminar
            libreroMueble.classList.add('highlight');

            // Mostrar Info Card
            document.getElementById('info-titulo').textContent = libro.titulo;
            document.getElementById('info-autor').textContent = libro.autor;
            document.getElementById('info-librero').textContent = codigoDB;
            document.getElementById('info-fila').textContent = libro.fila;
            infoCard.classList.remove('hidden');
        } else {
            alert(`El libro está en el librero ${codigoDB} (Fila ${libro.fila}), pero aún no está mapeado en el dibujo SVG. Por favor actualiza la variable MAPEO_LIBREROS en el código.`);
        }
    }

    function cerrarInfo() {
        infoCard.classList.add('hidden');
        document.querySelectorAll('.librero').forEach(el => {
            el.classList.remove('highlight');
        });
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