<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Reporte Mensual Asesor Fiscal</title>

    <style>
        @page {
            size: Letter portrait;
            margin: 8mm 9mm 8mm 9mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 7px;
            color: #111;
        }

        .hoja {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid #222;
            padding: 2px 3px;
            vertical-align: middle;
        }

        /* =====================================================
           ENCABEZADO
        ====================================================== */

        .encabezado {
            margin-bottom: 3px;
        }

        .encabezado td {
            border: none;
        }

        .logo {
            width: 35%;
            text-align: left;
            vertical-align: middle;
        }

        .logo img {
            width: 235px;
            max-height: 48px;
            object-fit: contain;
        }

        .titulo-principal {
            width: 65%;
            text-align: center;
            vertical-align: middle;
        }

        .titulo-reporte {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .subtitulo-reporte {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* =====================================================
           DATOS DEL ASESOR
        ====================================================== */

        .datos-asesor {
            margin-bottom: 4px;
        }

        .datos-asesor td {
            height: 15px;
        }

        .etiqueta {
            width: 17%;
            font-weight: bold;
            text-align: left;
            background: #d9d9d9;
        }

        .dato {
            width: 83%;
        }

        /* =====================================================
           ESTRUCTURA PRINCIPAL
        ====================================================== */

        .columnas {
            width: 100%;
            border-collapse: separate;
            border-spacing: 5px 0;
            margin-left: -5px;
            margin-right: -5px;
        }

        .columna-izquierda,
        .columna-derecha {
            width: 50%;
            vertical-align: top;
        }

        /* =====================================================
           TITULOS DE BLOQUE
        ====================================================== */

        .bloque {
            margin-bottom: 5px;
            page-break-inside: avoid;
        }

        .bloque-titulo {
            background: #d9d9d9;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            padding: 3px;
        }

        .bloque-subtitulo {
            background: #d9d9d9;
            font-size: 7px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            padding: 2px;
        }

        /* =====================================================
           TABLAS COMPACTAS
        ====================================================== */

        .tabla td,
        .tabla th {
            font-size: 7px;
            line-height: 1.05;
        }

        .tabla th {
            background: #e5e5e5;
            font-weight: bold;
            text-align: center;
        }

        .texto {
            text-align: left;
        }

        .numero {
            text-align: center;
        }

        .monto {
            text-align: right;
        }

        .total {
            background: #d9d9d9;
            font-weight: bold;
        }

        /* =====================================================
           TABLA DE TRÁMITES
        ====================================================== */

        .tabla-tramites td:first-child {
            width: 72%;
        }

        .tabla-tramites td:last-child {
            width: 28%;
            text-align: center;
        }

        .tabla-tramites .total td {
            font-weight: bold;
        }

        /* =====================================================
           TRÁMITES ESTATALES
        ====================================================== */

        .tabla-estatales th:nth-child(1) {
            width: 34%;
        }

        .tabla-estatales th:nth-child(2),
        .tabla-estatales th:nth-child(3),
        .tabla-estatales th:nth-child(4) {
            width: 14%;
        }

        .tabla-estatales th:nth-child(5) {
            width: 24%;
        }

        .tabla-estatales .categoria {
            background: #d9d9d9;
            font-weight: bold;
            text-align: center;
        }

        /* =====================================================
           TOTALES
        ====================================================== */

        .tabla-totales td:first-child {
            width: 78%;
        }

        .tabla-totales td:last-child {
            width: 22%;
            text-align: center;
        }

        /* =====================================================
           ACTIVIDADES
        ====================================================== */

        .actividades-titulo {
            background: #d9d9d9;
            border: 1px solid #222;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            padding: 3px;
        }

        .actividades {
            border: 1px solid #222;
            min-height: 105px;
            padding: 5px;
            line-height: 1.35;
        }

        /* =====================================================
           FIRMA
        ====================================================== */

        .firma {
            margin-top: 5px;
            width: 100%;
        }

        .firma td {
            border: none;
            padding: 1px 3px;
        }

        .firma-label {
            width: 10%;
            font-weight: bold;
        }

        .firma-linea {
            width: 60%;
            border-bottom: 1px solid #222;
        }

        .firma-nombre {
            text-align: center;
            font-weight: bold;
            font-size: 7px;
        }

        /* =====================================================
           EVITAR CORTES
        ====================================================== */

        .no-cortar {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

<div class="hoja">

    {{-- =====================================================
         ENCABEZADO
    ====================================================== --}}

    <table class="encabezado">

        <tr>

            <td class="logo">

                <img src="{{ public_path('images/institucional/logo-nayarit.png') }}" alt="Gobierno del Estado de Nayarit">

            </td>

            <td class="titulo-principal">

                <div class="titulo-reporte">
                    REPORTE MENSUAL ASESOR FISCAL
                </div>

                <div class="subtitulo-reporte">
                    ESTATALES Y RÉGIMEN DE INCORPORACIÓN FISCAL (RIF)
                </div>

            </td>

        </tr>

    </table>


    {{-- =====================================================
         DATOS DEL ASESOR
    ====================================================== --}}

    <table class="datos-asesor">

        <tr>

            <td class="etiqueta">
                FECHA:
            </td>

            <td class="dato">
                {{ $reporte->encabezado['periodo']['fecha_inicio'] ?? '' }}
                AL
                {{ $reporte->encabezado['periodo']['fecha_fin'] ?? '' }}
            </td>

        </tr>

        <tr>

            <td class="etiqueta">
                NOMBRE DEL ASESOR:
            </td>

            <td class="dato">
                {{ $reporte->encabezado['consulta']['asesor'] ?? 'TODOS' }}
            </td>

        </tr>

        <tr>

            <td class="etiqueta">
                PUESTO:
            </td>

            <td class="dato">
                ASESOR FISCAL
            </td>

        </tr>

    </table>


    {{-- =====================================================
         DOS COLUMNAS
    ====================================================== --}}

    <table class="columnas">

        <tr>

            {{-- =================================================
                 COLUMNA IZQUIERDA
            ================================================== --}}

            <td class="columna-izquierda">


                {{-- TRÁMITES AUTO SERVICIO RIF --}}

                <div class="bloque no-cortar">

                    <table class="tabla tabla-tramites">

                        <tr>
                            <td colspan="2" class="bloque-titulo">
                                TRÁMITES AUTO SERVICIO RIF
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                AUMENTO / DISMINUCIÓN DE CAMBIO DE ACTIVIDAD ECONÓMICA Y/O TRABAJADORES
                            </td>
                            <td class="numero">-</td>
                        </tr>

                        <tr>
                            <td class="texto">
                                CAMBIO DE DOMICILIO FISCAL
                            </td>
                            <td class="numero">-</td>
                        </tr>

                        <tr>
                            <td class="texto">
                                APERTURA DE ESTABLECIMIENTO O SUCURSAL
                            </td>
                            <td class="numero">-</td>
                        </tr>

                        <tr>
                            <td class="texto">
                                CIERRE DE ESTABLECIMIENTO O SUCURSAL
                            </td>
                            <td class="numero">-</td>
                        </tr>

                        <tr>
                            <td class="texto">
                                SUSPENSIÓN DE ACTIVIDADES
                            </td>
                            <td class="numero">-</td>
                        </tr>

                        <tr>
                            <td class="texto">
                                GENERACIÓN DE CONTRASEÑA
                            </td>
                            <td class="numero">-</td>
                        </tr>

                        <tr>
                            <td class="texto">
                                ACTUALIZACIÓN DE CONTRASEÑA
                            </td>
                            <td class="numero">-</td>
                        </tr>

                        <tr>
                            <td class="texto">
                                PAPEL DE TRABAJO (GASTOS O INGRESOS)
                            </td>
                            <td class="numero">-</td>
                        </tr>

                        <tr>
                            <td class="texto">
                                CITAS SAT
                            </td>
                            <td class="numero">-</td>
                        </tr>

                        <tr>
                            <td class="texto">
                                CITAS E. FIRMA Y/O SELLOS DIGITALES
                            </td>
                            <td class="numero">-</td>
                        </tr>

                        <tr>
                            <td class="texto">
                                CREACIÓN DE CORREO ELECTRÓNICO
                            </td>
                            <td class="numero">
                                {{ number_format($reporte->resumenes['general']['CORREO'] ?? 0) }}
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                OPINIÓN DE CUMPLIMIENTO
                            </td>
                            <td class="numero">-</td>
                        </tr>

                        <tr>
                            <td class="texto">
                                BUZÓN TRIBUTARIO / OTROS SERVICIOS ELECTRÓNICOS
                            </td>
                            <td class="numero">-</td>
                        </tr>

                        <tr>
                            <td class="texto">
                                REIMPRESIONES DE CONSTANCIAS Y/O ACUSES
                            </td>
                            <td class="numero">-</td>
                        </tr>

                        <tr class="total">
                            <td class="texto">
                                TOTAL TRÁMITES AUTO SERVICIO RIF
                            </td>
                            <td class="numero">-</td>
                        </tr>

                    </table>

                </div>


                {{-- MIS CUENTAS --}}

                <div class="bloque no-cortar">

                    <table class="tabla">

                        <tr>
                            <td colspan="3" class="bloque-titulo">
                                MIS CUENTAS
                            </td>
                        </tr>

                        <tr>
                            <th>CONCEPTO</th>
                            <th>TOTAL</th>
                            <th>MONTO VIRTUAL RIF</th>
                        </tr>

                        <tr>
                            <td class="texto">
                                FACTURACIÓN
                            </td>

                            <td class="numero">-</td>

                            <td class="monto">
                                $0.00
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                DECLARACIÓN BIMESTRAL
                            </td>

                            <td class="numero">-</td>

                            <td class="monto">
                                $0.00
                            </td>
                        </tr>

                        <tr class="total">

                            <td class="texto">
                                TOTAL TRÁMITES MIS CUENTAS RIF
                            </td>

                            <td class="numero">-</td>

                            <td class="monto">
                                $0.00
                            </td>

                        </tr>

                    </table>

                </div>


                {{-- ASESORÍAS RIF --}}

                <div class="bloque no-cortar">

                    <table class="tabla tabla-totales">

                        <tr>
                            <td colspan="2" class="bloque-titulo">
                                ASESORÍAS Y ORIENTACIONES FISCALES RIF
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                TOTAL DE ASESORÍAS PERSONALES RIF
                            </td>

                            <td class="numero">
                                {{ number_format($reporte->resumenes['asesorias']['PRESENCIAL'] ?? 0) }}
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                TOTAL DE ASESORÍAS TELEFÓNICAS RIF
                            </td>

                            <td class="numero">
                                {{ number_format($reporte->resumenes['asesorias']['TELEFONICA'] ?? 0) }}
                            </td>
                        </tr>

                    </table>

                </div>


                {{-- PROYECTOS / CORREOS --}}

                <div class="bloque no-cortar">

                    <table class="tabla tabla-totales">

                        <tr>

                            <td class="texto">
                                TOTAL DE PROYECTOS REALIZADOS
                            </td>

                            <td class="numero">
                                {{ number_format($reporte->complementario['proyectos_realizados'] ?? 0) }}
                            </td>

                        </tr>

                        <tr>

                            <td class="texto">
                                TOTAL DE CORREOS ELECTRÓNICOS
                            </td>

                            <td class="numero">
                                {{ number_format($reporte->resumenes['general']['CORREO'] ?? 0) }}
                            </td>

                        </tr>

                    </table>

                </div>


                {{-- SOLVENTACIONES --}}

                <div class="bloque no-cortar">

                    <table class="tabla tabla-totales">

                        <tr>
                            <td class="bloque-titulo" colspan="2">
                                SOLVENTACIÓN DE REQUERIMIENTOS
                            </td>
                        </tr>

                        <tr>

                            <td class="texto">
                                OBLIGACIONES ESTATALES
                            </td>

                            <td class="numero">
                                {{ number_format($reporte->solventaciones['estatales'] ?? 0) }}
                            </td>

                        </tr>

                        <tr>

                            <td class="texto">
                                OBLIGACIONES FEDERALES
                            </td>

                            <td class="numero">
                                {{ number_format($reporte->solventaciones['federales'] ?? 0) }}
                            </td>

                        </tr>

                        <tr>

                            <td class="texto">
                                SOLVENTACIÓN Y/O VERIFICACIÓN DE DATOS O EXHORTOS
                            </td>

                            <td class="numero">
                                {{ number_format($reporte->solventaciones['exhortos'] ?? 0) }}
                            </td>

                        </tr>

                        <tr class="total">

                            <td class="texto">
                                TOTAL DE REQUERIMIENTOS Y EXHORTOS
                            </td>

                            <td class="numero">
                                {{ number_format($reporte->solventaciones['total'] ?? 0) }}
                            </td>

                        </tr>

                    </table>

                </div>


            </td>


            {{-- =================================================
                 COLUMNA DERECHA
            ================================================== --}}

            <td class="columna-derecha">


                {{-- TRÁMITES ESTATALES --}}

                <div class="bloque no-cortar">

                    <table class="tabla tabla-estatales">

                        <tr>
                            <td colspan="5" class="bloque-titulo">
                                TRÁMITES ESTATALES
                            </td>
                        </tr>

                        <tr>
                            <th>
                                CONCEPTO
                            </th>

                            <th>
                                PERSONAL
                            </th>

                            <th>
                                TELEFÓNICA
                            </th>

                             <th>
                                EMAIL
                            </th>

                            <th>
                                MONTO VIRTUAL
                            </th>
                        </tr>


                        {{-- =================================================
                            NÓMINAS
                        ================================================== --}}

                        <tr>
                            <td colspan="5" class="categoria">
                                NÓMINAS
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                ASESORÍAS
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['nominas']['asesorias']['PRESENCIAL'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['nominas']['asesorias']['TELEFONICA'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['nominas']['asesorias']['CORREO'] ?? 0
                                ) }}
                            </td>

                            <td class="monto">
                                ${{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['nominas']['asesorias']['MONTO_VIRTUAL'] ?? 0,
                                    2
                                ) }}
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                DECLARACIONES Y TRÁMITES
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['nominas']['declaraciones_tramites']['PRESENCIAL'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['nominas']['declaraciones_tramites']['TELEFONICA'] ?? 0
                                ) }}
                            </td>

                            <td class="monto">
                                ${{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['nominas']['declaraciones_tramites']['MONTO_VIRTUAL'] ?? 0,
                                    2
                                ) }}
                            </td>
                        </tr>


                        {{-- =================================================
                            HOSPEDAJE
                        ================================================== --}}

                        <tr>
                            <td colspan="5" class="categoria">
                                HOSPEDAJE
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                ASESORÍAS
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['hospedaje']['asesorias']['PRESENCIAL'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['hospedaje']['asesorias']['TELEFONICA'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['hospedaje']['asesorias']['CORREO'] ?? 0
                                ) }}
                            </td>

                            <td class="monto">
                                ${{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['hospedaje']['asesorias']['MONTO_VIRTUAL'] ?? 0,
                                    2
                                ) }}
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                DECLARACIONES Y TRÁMITES
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['hospedaje']['declaraciones_tramites']['PRESENCIAL'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['hospedaje']['declaraciones_tramites']['TELEFONICA'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['hospedaje']['declaraciones_tramites']['CORREO'] ?? 0
                                ) }}
                            </td>

                            <td class="monto">
                                ${{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['hospedaje']['declaraciones_tramites']['MONTO_VIRTUAL'] ?? 0,
                                    2
                                ) }}
                            </td>
                        </tr>


                        {{-- =================================================
                            IMPUESTO CEDULARES
                        ================================================== --}}

                        <tr>
                            <td colspan="5" class="categoria">
                                IMPUESTO CEDULARES
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                ASESORÍAS
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['cedulares']['asesorias']['PRESENCIAL'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['cedulares']['asesorias']['TELEFONICA'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['cedulares']['asesorias']['CORREO'] ?? 0
                                ) }}
                            </td>

                            <td class="monto">
                                ${{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['cedulares']['asesorias']['MONTO_VIRTUAL'] ?? 0,
                                    2
                                ) }}
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                DECLARACIONES Y TRÁMITES
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['cedulares']['declaraciones_tramites']['PRESENCIAL'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['cedulares']['declaraciones_tramites']['TELEFONICA'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['cedulares']['declaraciones_tramites']['CORREO'] ?? 0
                                ) }}
                            </td>

                            <td class="monto">
                                ${{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['cedulares']['declaraciones_tramites']['MONTO_VIRTUAL'] ?? 0,
                                    2
                                ) }}
                            </td>
                        </tr>


                        {{-- =================================================
                            VENTA DE BEBIDAS CON CONTENIDO ALCOHÓLICO
                        ================================================== --}}

                        <tr>
                            <td colspan="5" class="categoria">
                                VENTA DE BEBIDAS CON CONTENIDO ALCOHÓLICO
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                ASESORÍAS
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['bebidas_alcoholicas']['asesorias']['PRESENCIAL'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['bebidas_alcoholicas']['asesorias']['TELEFONICA'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['bebidas_alcoholicas']['asesorias']['CORREO'] ?? 0
                                ) }}
                            </td>

                            <td class="monto">
                                ${{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['bebidas_alcoholicas']['asesorias']['MONTO_VIRTUAL'] ?? 0,
                                    2
                                ) }}
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                DECLARACIONES Y TRÁMITES
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['bebidas_alcoholicas']['declaraciones_tramites']['PRESENCIAL'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['bebidas_alcoholicas']['declaraciones_tramites']['TELEFONICA'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['bebidas_alcoholicas']['declaraciones_tramites']['CORREO'] ?? 0
                                ) }}
                            </td>

                            <td class="monto">
                                ${{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['bebidas_alcoholicas']['declaraciones_tramites']['MONTO_VIRTUAL'] ?? 0,
                                    2
                                ) }}
                            </td>
                        </tr>


                        {{-- =================================================
                            JUEGOS / APUESTAS / RIFAS / LOTERÍAS / SORTEOS
                        ================================================== --}}

                        <tr>
                            <td colspan="5" class="categoria">
                                JUEGOS / APUESTAS / RIFAS / LOTERÍAS / SORTEOS
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                ASESORÍAS
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['juegos_apuestas_rifas']['asesorias']['PRESENCIAL'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['juegos_apuestas_rifas']['asesorias']['TELEFONICA'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['juegos_apuestas_rifas']['asesorias']['CORREO'] ?? 0
                                ) }}
                            </td>

                            <td class="monto">
                                ${{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['juegos_apuestas_rifas']['asesorias']['MONTO_VIRTUAL'] ?? 0,
                                    2
                                ) }}
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                DECLARACIONES Y TRÁMITES
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['juegos_apuestas_rifas']['declaraciones_tramites']['PRESENCIAL'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['juegos_apuestas_rifas']['declaraciones_tramites']['TELEFONICA'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['juegos_apuestas_rifas']['declaraciones_tramites']['CORREO'] ?? 0
                                ) }}
                            </td>

                            <td class="monto">
                                ${{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['juegos_apuestas_rifas']['declaraciones_tramites']['MONTO_VIRTUAL'] ?? 0,
                                    2
                                ) }}
                            </td>
                        </tr>


                        {{-- =================================================
                            OTROS IMPUESTOS ESTATALES
                        ================================================== --}}

                        <tr>
                            <td colspan="5" class="categoria">
                                OTROS IMPUESTOS ESTATALES
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                ASESORÍAS
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['otros']['asesorias']['PRESENCIAL'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['otros']['asesorias']['TELEFONICA'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['otros']['asesorias']['CORREO'] ?? 0
                                ) }}
                            </td>

                            <td class="monto">
                                ${{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['otros']['asesorias']['MONTO_VIRTUAL'] ?? 0,
                                    2
                                ) }}
                            </td>
                        </tr>

                        <tr>
                            <td class="texto">
                                DECLARACIONES Y TRÁMITES
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['otros']['declaraciones_tramites']['PRESENCIAL'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['otros']['declaraciones_tramites']['TELEFONICA'] ?? 0
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['otros']['declaraciones_tramites']['CORREO'] ?? 0
                                ) }}
                            </td>

                            <td class="monto">
                                ${{ number_format(
                                    $reporte->tramites_estatales_resumen['grupos']['otros']['declaraciones_tramites']['MONTO_VIRTUAL'] ?? 0,
                                    2
                                ) }}
                            </td>
                        </tr>


                        {{-- =================================================
                            TOTAL ESTATALES
                        ================================================== --}}

                        <tr class="total">

                            <td>
                                TOTAL ESTATALES
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['totales']['asesorias']['PRESENCIAL']
                                    +
                                    $reporte->tramites_estatales_resumen['totales']['declaraciones_tramites']['PRESENCIAL']
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['totales']['asesorias']['TELEFONICA']
                                    +
                                    $reporte->tramites_estatales_resumen['totales']['declaraciones_tramites']['TELEFONICA']
                                ) }}
                            </td>

                            <td class="numero">
                                {{ number_format(
                                    $reporte->tramites_estatales_resumen['totales']['asesorias']['CORREO']
                                    +
                                    $reporte->tramites_estatales_resumen['totales']['declaraciones_tramites']['CORREO']
                                ) }}
                            </td>

                            <td class="monto">
                                ${{ number_format(
                                    $reporte->tramites_estatales_resumen['totales']['asesorias']['MONTO_VIRTUAL']
                                    +
                                    $reporte->tramites_estatales_resumen['totales']['declaraciones_tramites']['MONTO_VIRTUAL'],
                                    2
                                ) }}
                            </td>

                        </tr>

                    </table>

                </div>


                {{-- TALLERES FISCALES --}}

                <div class="bloque no-cortar">

                    <table class="tabla">

                        <tr>

                            <td colspan="2" class="bloque-titulo">
                                TALLERES FISCALES
                            </td>

                        </tr>

                        <tr>

                            <td class="texto">
                                TOTAL DE TALLERES FISCALES RIF
                            </td>

                            <td class="numero">
                                {{ number_format($reporte->complementario['talleres_rif'] ?? 0) }}
                            </td>

                        </tr>

                        <tr>

                            <td class="texto">
                                TOTAL DE TALLERES IMPUESTOS ESTATALES
                            </td>

                            <td class="numero">
                                {{ number_format($reporte->complementario['talleres_estatales'] ?? 0) }}
                            </td>

                        </tr>

                        <tr>

                            <td class="texto">
                                NÚMERO DE CONTRIBUYENTES (RIF)
                            </td>

                            <td class="numero">
                                {{ number_format($reporte->contribuyentes['rif'] ?? 0) }}
                            </td>

                        </tr>

                        <tr>

                            <td class="texto">
                                NÚMERO DE CONTRIBUYENTES (ESTATALES)
                            </td>

                            <td class="numero">
                                {{ number_format($reporte->contribuyentes['estatales'] ?? 0) }}
                            </td>

                        </tr>

                    </table>

                </div>


                {{-- TOTALES GENERALES DE ASESORÍAS --}}

                <div class="bloque no-cortar">

                    <table class="tabla tabla-totales">

                        <tr>

                            <td class="texto">
                                TOTAL DE ASESORÍAS PERSONALES EN GENERAL
                            </td>

                            <td class="numero">
                                {{ number_format($reporte->resumenes['general']['PRESENCIAL'] ?? 0) }}
                            </td>

                        </tr>

                        <tr>

                            <td class="texto">
                                TOTAL DE ASESORÍAS TELEFÓNICAS EN GENERAL
                            </td>

                            <td class="numero">
                                {{ number_format($reporte->resumenes['general']['TELEFONICA'] ?? 0) }}
                            </td>

                        </tr>

                        <tr class="total">

                            <td class="texto">
                                TOTAL GENERAL DE ASESORÍAS
                            </td>

                            <td class="numero">
                                {{ number_format($reporte->resumenes['general']['TOTAL'] ?? 0) }}
                            </td>

                        </tr>

                    </table>

                </div>


            </td>

        </tr>

    </table>


    {{-- =====================================================
         ACTIVIDADES REALIZADAS EN EL MES
    ====================================================== --}}

    <div class="no-cortar">

        <div class="actividades-titulo">
            ACTIVIDADES REALIZADAS EN EL MES (FUNCIONES ADICIONALES)
        </div>

        <div class="actividades">

            @if(!empty($reporte->complementario['actividades_adicionales']))

                {!! nl2br(e($reporte->complementario['actividades_adicionales'])) !!}

            @else

                &nbsp;

            @endif

        </div>

    </div>


    {{-- =====================================================
         FIRMA
    ====================================================== --}}

    <table class="firma">

        <tr>

            <td class="firma-label">
                FIRMA:
            </td>

            <td class="firma-linea">
                &nbsp;
            </td>

        </tr>

        <tr>

            <td>
                &nbsp;
            </td>

            <td class="firma-nombre">
                {{ $reporte->pie['nombre_firma'] ?? '(NOMBRE DEL ASESOR)' }}
            </td>

        </tr>

    </table>

</div>

</body>
</html>