<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha de Préstamo Interno</title>
    <style>
        /* Tipografía general más compacta */
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            font-size: 11px; /* Letra más pequeña para ahorrar espacio */
            color: #000; 
            margin: 0;
            padding: 10px; /* Menos espacio en los bordes */
        }

        /* Contenedor principal de la ficha */
        .ficha-container {
            width: 100%;
            max-width: 480px; 
            margin: 0 auto;
        }

        /* Folio */
        .folio-pequeno { 
            text-align: right; 
            font-size: 10px; 
            color: #666; 
            margin-bottom: -10px;
            font-weight: bold;
        }

        /* Encabezado sin tanto interlineado */
        .header {
            text-align: center;
            margin-bottom: 8px;
            line-height: 1.1;
        }
        .header h1 { margin: 0; font-size: 14px; font-weight: normal; }
        .header h2 { margin: 0; font-size: 13px; font-weight: normal; }
        .header h3 { margin: 0; font-size: 12px; font-weight: normal; }

        /* Títulos de sección ultra delgados */
        .section-title {
            background-color: #000;
            color: #fff;
            text-align: center;
            font-weight: bold;
            padding: 2px 0;
            margin: 6px 0;
            font-size: 12px;
            letter-spacing: 1px;
        }

        /* Tablas con celdas pegadas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }
        td {
            padding: 2px 0; /* Casi nulo para pegar las líneas */
            vertical-align: bottom;
        }
        .label {
            font-weight: bold;
            white-space: nowrap;
            width: 1%;
            padding-right: 5px;
            font-size: 11px;
        }
        .data-line {
            border-bottom: 1px solid #000; 
            width: 99%;
            font-family: 'Courier New', Courier, monospace; 
            font-size: 12px;
            padding-left: 5px;
        }

        /* Pie de página pegado */
        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 9px;
            border-top: 1px solid #000;
            padding-top: 3px;
        }
        .footer strong {
            display: block;
            margin-bottom: 1px;
            font-size: 10px;
        }

        /* Sello pequeño (60x60px) */
        .sello-area {
            margin-top: 10px;
            text-align: center;
        }
        .caja-sello {
            width: 60px;
            height: 60px;
            border: 1.5px dashed #999;
            margin: 0 auto;
            border-radius: 50%;
            display: table;
        }
        .texto-sello {
            display: table-cell;
            vertical-align: middle;
            color: #999;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <div class="ficha-container">
        
        <!-- FOLIO -->
        <div class="folio-pequeno">
            Folio: #<?= str_pad($ficha['id_ficha'], 5, '0', STR_PAD_LEFT) ?>
        </div>

        <!-- ENCABEZADO -->
        <div class="header">
            <h1>JARDÍN ETNOBIOLÓGICO DE OAXACA</h1>
            <h2>BIBLIOTECA</h2>
            <h3>FICHA DE PRÉSTAMO INTERNO</h3>
        </div>

        <!-- SECCIÓN: LIBRO -->
        <div class="section-title">LIBRO</div>
        
        <table><tr><td class="label">CLASIFICACIÓN:</td><td class="data-line"><?= esc($ficha['clasificacion_lomo']) ?></td></tr></table>
        <table><tr><td class="label">TÍTULO:</td><td class="data-line"><?= esc($ficha['titulo']) ?></td></tr></table>
        <table><tr><td class="label">AUTOR (S):</td><td class="data-line"><?= esc($ficha['autor']) ?></td></tr></table>
        <table>
            <tr>
                <td class="label">VOL:</td><td class="data-line" style="width: 30%;"><?= esc($ficha['volumen']) ?: 'N/A' ?></td>
                <td class="label" style="padding-left: 15px;">AÑO:</td><td class="data-line"><?= esc($ficha['anio_publicacion']) ?: 'N/A' ?></td>
            </tr>
        </table>

        <!-- SECCIÓN: DATOS DEL LECTOR -->
        <div class="section-title">DATOS DEL LECTOR</div>
        
        <table><tr><td class="label">NOMBRE:</td><td class="data-line"><?= esc($ficha['nombre_completo']) ?></td></tr></table>
        <table>
            <tr>
                <td class="label">PAÍS:</td><td class="data-line" style="width: 40%;"><?= esc($ficha['pais']) ?></td>
                <td class="label" style="padding-left: 10px;">ESTADO:</td><td class="data-line"><?= esc($ficha['estado_lector']) ?></td>
            </tr>
        </table>
        <table><tr><td class="label">OCUPACIÓN:</td><td class="data-line"><?= esc($ficha['ocupacion']) ?: 'No especificada' ?></td></tr></table>
        <table><tr><td class="label">INSTITUCIÓN:</td><td class="data-line"><?= esc($ficha['institucion']) ?: 'No especificada' ?></td></tr></table>
        <table><tr><td class="label">FECHA:</td><td class="data-line"><?= date('d / m / Y', strtotime($ficha['fecha_solicitud'])) ?></td></tr></table>

        <!-- ÁREA PARA EL SELLO INSTITUCIONAL -->
        <div class="sello-area">
            <div class="caja-sello">
                <div class="texto-sello">
                    <p style="margin:1px 0;">SELLO DE LA</p>
                    <p style="margin:1px 0;">INSTITUCIÓN</p>
                </div>
            </div>
        </div>

        <!-- PIE DE PÁGINA (Aviso) -->
        <div class="footer">
            <strong>AVISO DE PRIVACIDAD</strong>
            LOS DATOS RECABADOS SON CON FINES ESTADÍSTICOS ÚNICAMENTE.
        </div>

    </div>

</body>
</html>