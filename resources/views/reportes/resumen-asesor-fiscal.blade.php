<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Resumen del Asesor Fiscal</title>

    <style>
        @page {
            size: Letter portrait;
            margin: 8mm 7mm 8mm 7mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8.5px;
            color: #111827;
        }

        .hoja {
            width: 100%;
        }

        /* =========================
           ENCABEZADO
        ========================== */

        .encabezado {
            border: 1px solid #94a3b8;
            padding: 6px 8px;
            margin-bottom: 5px;
        }

        .encabezado-tabla {
            width: 100%;
            border-collapse: collapse;
        }

        .logo {
            width: 27%;
            vertical-align: middle;
        }

        .logo img {
            width: 100%;
            max-height: 45px;
            object-fit: contain;
        }

        .titulo {
            width: 73%;
            text-align: center;
            vertical-align: middle;
        }

        .dependencia {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .subtitulo {
            font-size: 7px;
            font-weight: bold;
            margin-top: 2px;
            text-transform: uppercase;
        }

        .titulo-reporte {
            font-size: 12px;
            font-weight: bold;
            margin-top: 3px;
            text-transform: uppercase;
        }

        /* =========================
           CONSULTA
        ========================== */

        .consulta {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .consulta td {
            border: 1px solid #cbd5e1;
            padding: 3px 5px;
        }

        .consulta .etiqueta {
            width: 12%;
            font-weight: bold;
            background: #f1f5f9;
        }

        /* =========================
           SECCIONES
        ========================== */

        .titulo-seccion {
            background: #1e293b;
            color: white;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 5px 6px;
            margin-top: 5px;
            margin-bottom: 3px;
        }

        /* =========================
           TABLAS
        ========================== */

        table.reporte {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3px;
            table-layout: fixed;
        }

        table.reporte th,
        table.reporte td {
            border: 1px solid #cbd5e1;
            padding: 3px 4px;
            vertical-align: middle;
        }

        table.reporte th {
            background: #f1f5f9;
            font-weight: bold;
            text-align: center;
        }

        table.reporte td {
            text-align: right;
        }

        table.reporte td:first-child {
            text-align: left;
        }

        .total {
            background: #e2e8f0;
            font-weight: bold;
        }

        /* =========================
           RESUMEN PRINCIPAL
        ========================== */

        .tabla-principal th:first-child {
            width: 34%;
        }

        .tabla-principal th:nth-child(2),
        .tabla-principal th:nth-child(3),
        .tabla-principal th:nth-child(4),
        .tabla-principal th:nth-child(5) {
            width: 11%;
        }

        .tabla-principal th:last-child {
            width: 12%;
        }

        /* =========================
           DOS COLUMNAS
        ========================== */

        .dos-columnas {
            width: 100%;
            border-collapse: separate;
            border-spacing: 5px 0;
            margin-left: -5px;
            margin-right: -5px;
        }

        .dos-columnas td {
            width: 50%;
            vertical-align: top;
        }

        /* =========================
           ACTIVIDADES
        ========================== */

        .tabla-complementarios th {
            width: 25%;
        }

        .actividades {
            border: 1px solid #cbd5e1;
            min-height: 48px;
            padding: 6px;
            line-height: 1.4;
            margin-bottom: 3px;
        }

        /* =========================
           FIRMA
        ========================== */

        .firma {
            width: 45%;
            margin: 14px auto 0;
            text-align: center;
        }

        .firma-linea {
            border-top: 1px solid #374151;
            margin-bottom: 3px;
        }

        .firma-label {
            font-size: 7px;
            font-weight: bold;
        }

        .firma-nombre {
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .evitar-corte {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

<div class="hoja">

    {{-- =====================================================
         ENCABEZADO
    ====================================================== --}}

    <div class="encabezado">

        <table class="encabezado-tabla">
            <tr>

                <td class="logo">
                    <img
                        src="{{ public_path('images/institucional/logo-nayarit.png') }}"
                        alt="Gobierno del Estado de Nayarit"
                    >
                </td>

                <td class="titulo">

                    <div class="dependencia">
                        Gobierno del Estado de Nayarit
                    </div>

                    <div class="subtitulo">
                        Secretaría de Finanzas
                    </div>

                    <div class="subtitulo">
                        Departamento de Asistencia al Contribuyente
                    </div>

                    <div class="titulo-reporte">
                        {{ $reporte->encabezado['reporte']['nombre'] ?? 'REPORTE DEL ASESOR FISCAL' }}
                    </div>

                    <div class="subtitulo">
                        RESUMEN DE ACTIVIDADES
                    </div>

                </td>

            </tr>
        </table>

    </div>


    {{-- =====================================================
         DATOS DE CONSULTA
    ====================================================== --}}

    <table class="consulta">

        <tr>

            <td class="etiqueta">
                ASESOR
            </td>

            <td>
                {{ $reporte->encabezado['consulta']['asesor'] ?? 'TODOS' }}
            </td>

            <td class="etiqueta">
                MÓDULO
            </td>

            <td>
                {{ $reporte->encabezado['modulo'] ?? 'TEPIC' }}
            </td>

        </tr>

        <tr>

            <td class="etiqueta">
                PERIODO
            </td>

            <td>
                {{ $reporte->encabezado['periodo']['fecha_inicio'] ?? '' }}
                AL
                {{ $reporte->encabezado['periodo']['fecha_fin'] ?? '' }}
            </td>

            <td class="etiqueta">
                MODALIDAD
            </td>

            <td>
                {{ $reporte->encabezado['consulta']['modalidad'] ?? 'TODAS' }}
            </td>

        </tr>

    </table>


    {{-- =====================================================
         RESUMEN DE ACTIVIDADES
    ====================================================== --}}

    <div class="titulo-seccion">
        ATENCIÓN Y SERVICIOS REALIZADOS
    </div>

    <table class="reporte tabla-principal">

        <thead>

            <tr>
                <th>CONCEPTO</th>
                <th>PRESENCIAL</th>
                <th>TELEFÓNICA</th>
                <th>CORREO</th>
                <th>TOTAL</th>
                <th>MONTO VIRTUAL</th>
            </tr>

        </thead>

        <tbody>

            <tr>

                <td>
                    ASESORÍAS
                </td>

                <td>
                    {{ number_format($reporte->resumenes['asesorias']['PRESENCIAL'] ?? 0) }}
                </td>

                <td>
                    {{ number_format($reporte->resumenes['asesorias']['TELEFONICA'] ?? 0) }}
                </td>

                <td>
                    {{ number_format($reporte->resumenes['asesorias']['CORREO'] ?? 0) }}
                </td>

                <td>
                    {{ number_format($reporte->resumenes['asesorias']['TOTAL'] ?? 0) }}
                </td>

                <td>
                    ${{ number_format($reporte->resumenes['asesorias']['MONTO_VIRTUAL'] ?? 0, 2) }}
                </td>

            </tr>


            <tr>

                <td>
                    DECLARACIONES Y TRÁMITES
                </td>

                <td>
                    {{ number_format($reporte->resumenes['declaraciones_tramites']['PRESENCIAL'] ?? 0) }}
                </td>

                <td>
                    {{ number_format($reporte->resumenes['declaraciones_tramites']['TELEFONICA'] ?? 0) }}
                </td>

                <td>
                    {{ number_format($reporte->resumenes['declaraciones_tramites']['CORREO'] ?? 0) }}
                </td>

                <td>
                    {{ number_format($reporte->resumenes['declaraciones_tramites']['TOTAL'] ?? 0) }}
                </td>

                <td>
                    ${{ number_format($reporte->resumenes['declaraciones_tramites']['MONTO_VIRTUAL'] ?? 0, 2) }}
                </td>

            </tr>


            <tr class="total">

                <td>
                    TOTAL GENERAL
                </td>

                <td>
                    {{ number_format($reporte->resumenes['general']['PRESENCIAL'] ?? 0) }}
                </td>

                <td>
                    {{ number_format($reporte->resumenes['general']['TELEFONICA'] ?? 0) }}
                </td>

                <td>
                    {{ number_format($reporte->resumenes['general']['CORREO'] ?? 0) }}
                </td>

                <td>
                    {{ number_format($reporte->resumenes['general']['TOTAL'] ?? 0) }}
                </td>

                <td>
                    ${{ number_format($reporte->resumenes['general']['MONTO_VIRTUAL'] ?? 0, 2) }}
                </td>

            </tr>

        </tbody>

    </table>


    {{-- =====================================================
         CONTRIBUYENTES Y SOLVENTACIONES
    ====================================================== --}}

    <table class="dos-columnas">

        <tr>

            <td>

                <div class="titulo-seccion">
                    CONTRIBUYENTES ATENDIDOS
                </div>

                <table class="reporte">

                    <thead>

                        <tr>
                            <th>TIPO</th>
                            <th>TOTAL</th>
                        </tr>

                    </thead>

                    <tbody>

                        <tr>
                            <td>
                                RIF
                            </td>

                            <td>
                                {{ number_format($reporte->contribuyentes['rif'] ?? 0) }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                ESTATALES
                            </td>

                            <td>
                                {{ number_format($reporte->contribuyentes['estatales'] ?? 0) }}
                            </td>
                        </tr>

                        <tr class="total">
                            <td>
                                TOTAL
                            </td>

                            <td>
                                {{
                                    number_format(
                                        ($reporte->contribuyentes['rif'] ?? 0)
                                        +
                                        ($reporte->contribuyentes['estatales'] ?? 0)
                                    )
                                }}
                            </td>
                        </tr>

                    </tbody>

                </table>

            </td>


            <td>

                <div class="titulo-seccion">
                    SOLVENTACIÓN Y/O VERIFICACIÓN
                </div>

                <table class="reporte">

                    <tbody>

                        <tr>
                            <td>
                                Requerimientos obligaciones estatales
                            </td>

                            <td>
                                {{ number_format($reporte->solventaciones['estatales'] ?? 0) }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Requerimientos obligaciones federales
                            </td>

                            <td>
                                {{ number_format($reporte->solventaciones['federales'] ?? 0) }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Solventación y/o verificación de datos o exhortos
                            </td>

                            <td>
                                {{ number_format($reporte->solventaciones['exhortos'] ?? 0) }}
                            </td>
                        </tr>

                        <tr class="total">
                            <td>
                                TOTAL
                            </td>

                            <td>
                                {{ number_format($reporte->solventaciones['total'] ?? 0) }}
                            </td>
                        </tr>

                    </tbody>

                </table>

            </td>

        </tr>

    </table>


    {{-- =====================================================
         DATOS COMPLEMENTARIOS
    ====================================================== --}}

    <div class="titulo-seccion">
        ACTIVIDADES REALIZADAS EN EL MES (FUNCIONES ADICIONALES)
    </div>

    <table class="reporte tabla-complementarios">

        <thead>

            <tr>
                <th>TALLERES FISCALES RIF</th>
                <th>TALLERES FISCALES ESTATALES</th>
                <th>PROYECTOS REALIZADOS</th>
                <th>ACTIVIDADES ADICIONALES</th>
            </tr>

        </thead>

        <tbody>

            <tr>

                <td>
                    {{ number_format($reporte->complementario['talleres_rif'] ?? 0) }}
                </td>

                <td>
                    {{ number_format($reporte->complementario['talleres_estatales'] ?? 0) }}
                </td>

                <td>
                    {{ number_format($reporte->complementario['proyectos_realizados'] ?? 0) }}
                </td>

                <td>
                    {{ !empty($reporte->complementario['actividades_adicionales']) ? 'SÍ' : 'NO' }}
                </td>

            </tr>

        </tbody>

    </table>


    {{-- =====================================================
         DETALLE DE ACTIVIDADES ADICIONALES
    ====================================================== --}}

    @if(!empty($reporte->complementario['actividades_adicionales']))

        <div class="actividades">

            {!! nl2br(e($reporte->complementario['actividades_adicionales'])) !!}

        </div>

    @endif


    {{-- =====================================================
         FIRMA
    ====================================================== --}}

    <div class="firma">

        <div class="firma-linea"></div>

        <div class="firma-label">
            {{ $reporte->pie['firma_label'] ?? 'ASESOR FISCAL' }}
        </div>

        <div class="firma-nombre">
            {{ $reporte->pie['nombre_firma'] ?? '(NOMBRE DEL ASESOR RESPONSABLE)' }}
        </div>

    </div>

</div>

</body>
</html>