<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Reporte Mensual Orientador Fiscal</title>

    <style>

        @page {
            size: Letter;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 45px 80px 40px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #000;
        }


        /* =========================================================
           ENCABEZADO
           ========================================================= */

        .encabezado {
            text-align: center;
        }

        .logos {
            height: 75px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
        }

        .logo-finanzas {
            width: auto;
            max-width: 430px;
            max-height: 70px;
            object-fit: contain;
        }

        .titulo {
            margin-top: 5px;
            font-size: 15px;
            font-weight: bold;
        }

        .subtitulo {
            margin-top: 5px;
            font-size: 11px;
            font-weight: bold;
        }


        /* =========================================================
           DATOS GENERALES
           ========================================================= */

        .datos-generales {
            width: 100%;
            margin-top: 28px;
            border-collapse: collapse;
        }

        .datos-generales td {
            height: 21px;
            padding: 3px 7px;
            border: 1px solid #000;
        }

        .datos-generales .etiqueta {
            width: 160px;
            background: #d9d9d9;
            text-align: center;
            font-weight: bold;
        }


        /* =========================================================
           CUADROS SUPERIORES
           ========================================================= */

        .bloque-superior {
            display: flex;
            gap: 14px;
            margin-top: 24px;
        }

        .cuadro-afluencia {
            width: 47%;
        }

        .cuadro-rif {
            width: 53%;
        }

        .cuadro {
            border: 2px solid #000;
        }

        .cuadro-afluencia .cuadro {
            display: flex;
            min-height: 100px;
        }

        .cuadro-afluencia .cuadro-titulo {
            width: 78%;
            padding: 5px;
            background: #d9d9d9;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-weight: bold;
        }

        .cuadro-afluencia .cuadro-contenido {
            width: 22%;
            min-height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        .rif-titulo {
            min-height: 47px;
            padding: 5px;
            background: #d9d9d9;
            border-bottom: 2px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
        }

        .rif-fila {
            display: flex;
            min-height: 47px;
        }

        .rif-label {
            width: 50%;
            background: #d9d9d9;
            border-right: 2px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
        }

        .rif-valor {
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }


        /* =========================================================
           TOTALES
           ========================================================= */

        .tabla-totales {
            width: 100%;
            margin-top: 39px;
            border-collapse: collapse;
        }

        .tabla-totales td {
            height: 43px;
            border: 2px solid #000;
        }

        .tabla-totales .etiqueta {
            width: 80%;
            background: #d9d9d9;
            text-align: center;
            font-weight: bold;
        }

        .tabla-totales .valor {
            width: 20%;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
        }


        /* =========================================================
           ACTIVIDADES
           ========================================================= */

        .actividades {
            margin-top: 52px;
        }

        .actividades-titulo {
            height: 24px;
            padding: 3px;
            background: #d9d9d9;
            border: 2px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 9px;
            font-weight: bold;
        }

        .actividades-contenido {
            height: 170px;
            padding: 12px;
            border: 2px solid #000;
            border-top: none;
            font-size: 10px;
            white-space: pre-line;
        }


        /* =========================================================
           FIRMA
           ========================================================= */

        .firma {
            position: relative;
            margin-top: 34px;
        }

        .firma-label {
            position: absolute;
            top: 10px;
            left: 18px;
            font-weight: bold;
        }

        .firma-linea {
            height: 26px;
            margin-left: 72px;
            border-bottom: 2px solid #000;
        }

        .firma-nombre {
            margin-top: 7px;
            text-align: center;
            font-weight: bold;
        }

    </style>

</head>


<body>

    {{-- =========================================================
         ENCABEZADO
         ========================================================= --}}

    <div class="encabezado">

        <div class="logos">

            <img
                src="{{ public_path('images/institucional/logo-finanzas-nayarit.png') }}"
                class="logo-finanzas"
                alt="Secretaría de Finanzas"
            >

        </div>

        <div class="titulo">
            REPORTE MENSUAL ORIENTADOR FISCAL
        </div>

        <div class="subtitulo">
            ESTATALES Y RÉGIMEN DE INCORPORACIÓN FISCAL (RIF)
        </div>

    </div>


    {{-- =========================================================
         DATOS GENERALES
         ========================================================= --}}

    <table class="datos-generales">

        <tr>

            <td class="etiqueta">
                FECHA:
            </td>

            <td>
                {{ \Carbon\Carbon::parse($modelo['periodo']['fecha_inicio'])->format('d/m/Y') }}
                al
                {{ \Carbon\Carbon::parse($modelo['periodo']['fecha_fin'])->format('d/m/Y') }}
            </td>

        </tr>

        <tr>

            <td class="etiqueta">
                NOMBRE DEL ORIENTADOR:
            </td>

            <td>
                {{ $modelo['consulta']['orientador'] }}
            </td>

        </tr>

        <tr>

            <td class="etiqueta">
                PUESTO:
            </td>

            <td>
                ORIENTADOR FISCAL
            </td>

        </tr>

    </table>


    {{-- =========================================================
         AFLUENCIAS
         ========================================================= --}}

    <div class="bloque-superior">

        <div class="cuadro-afluencia">

            <div class="cuadro">

                <div class="cuadro-titulo">
                    TOTAL DE AFLUENCIAS EN GENERAL
                </div>

                <div class="cuadro-contenido">
                    {{ $modelo['total_afluencias'] }}
                </div>

            </div>

        </div>


        <div class="cuadro-rif">

            <div class="cuadro">

                <div class="rif-titulo">
                    AFLUENCIAS Y ORIENTACIONES FISCALES RIF
                </div>

                <div class="rif-fila">

                    <div class="rif-label">
                        Personales
                    </div>

                    <div class="rif-valor">
                        {{ $modelo['rif']['personales'] }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         TOTALES
         ========================================================= --}}

    <table class="tabla-totales">

        <tr>

            <td class="etiqueta">
                TOTAL DE TRÁMITES ESTATALES
            </td>

            <td class="valor">
                {{ $modelo['tramites_estatales'] }}
            </td>

        </tr>

        <tr>

            <td class="etiqueta">
                TOTAL DE REQUERIMIENTOS
            </td>

            <td class="valor">
                {{ $modelo['requerimientos'] }}
            </td>

        </tr>

        <tr>

            <td class="etiqueta">
                OTROS TRÁMITES
            </td>

            <td class="valor">
                {{ $modelo['otros_tramites'] }}
            </td>

        </tr>

    </table>


    {{-- =========================================================
         ACTIVIDADES
         ========================================================= --}}

    <div class="actividades">

        <div class="actividades-titulo">
            ACTIVIDADES REALIZADAS EN EL MES (FUNCIONES ADICIONALES)
        </div>

        <div class="actividades-contenido">

            @if (trim($modelo['actividades_adicionales'] ?? ''))

                {{ $modelo['actividades_adicionales'] }}

            @endif

        </div>

    </div>


    {{-- =========================================================
         FIRMA
         ========================================================= --}}

    <div class="firma">

        <div class="firma-label">
            FIRMA:
        </div>

        <div class="firma-linea"></div>

        <div class="firma-nombre">
            ({{ $modelo['consulta']['orientador'] }})
        </div>

    </div>

</body>

</html>