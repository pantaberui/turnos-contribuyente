<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">

    <title>Reporte General de Orientadores Fiscales</title>

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
            padding: 35px 55px 40px;
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
           DATOS DEL PERIODO
           ========================================================= */

        .datos-periodo {
            width: 100%;
            margin-top: 28px;
            border-collapse: collapse;
        }

        .datos-periodo td {
            height: 24px;
            padding: 4px 7px;
            border: 1px solid #000;
        }

        .datos-periodo .etiqueta {
            width: 150px;
            background: #d9d9d9;
            text-align: center;
            font-weight: bold;
        }


        /* =========================================================
           TABLA
           ========================================================= */

        .tabla-general th {
            height: 52px;
            padding: 8px 5px;
            background: #d9d9d9;
            text-align: center;
            vertical-align: middle;
            font-size: 8.5px;
            line-height: 1.25;
            font-weight: bold;
            text-transform: uppercase;
        }

        .tabla-general th br {
            line-height: 1.35;
        }

        .tabla-general th,
        .tabla-general td {
            border: 1px solid #000;
        }

        .tabla-general th {
            height: 42px;
            padding: 5px;
            background: #d9d9d9;
            text-align: center;
            vertical-align: middle;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .tabla-general td {
            padding: 7px 6px;
            vertical-align: middle;
            font-size: 10px;
        }


        /* =========================================================
           ANCHOS
           ========================================================= */

        .col-orientador {
            width: 27%;
        }

        .col-rif {
            width: 9%;
        }

        .col-afluencias {
            width: 11%;
        }

        .col-estatales {
            width: 11%;
        }

        .col-requerimientos {
            width: 12%;
        }

        .col-otros {
            width: 12%;
        }

        .col-actividades {
            width: 18%;
        }


        /* =========================================================
           CONTENIDO
           ========================================================= */

        .texto-orientador {
            font-weight: bold;
        }

        .numero {
            text-align: center;
            font-weight: bold;
        }

        .otros {
            text-align: center;
            font-size: 9px;
        }

        .actividades {
            white-space: pre-line;
            vertical-align: top !important;
        }

        .sin-actividades {
            color: #666;
            font-style: italic;
            font-size: 9px;
        }


        /* =========================================================
           TOTAL GENERAL
           ========================================================= */

        .fila-total {
            background: #d9d9d9;
            font-weight: bold;
        }

        .fila-total td {
            height: 45px;
            font-weight: bold;
        }


        /* =========================================================
           FIRMA
           ========================================================= */

        .firma {
            margin-top: 55px;
            text-align: center;
        }

        .firma-linea {
            width: 350px;
            margin: 40px auto 8px;
            border-top: 1px solid #000;
        }

        .firma-nombre {
            font-weight: bold;
        }

        .firma-puesto {
            margin-top: 4px;
            font-size: 10px;
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
            REPORTE GENERAL DE ORIENTADORES FISCALES
        </div>

        <div class="subtitulo">
            ESTATALES Y RÉGIMEN DE INCORPORACIÓN FISCAL (RIF)
        </div>

    </div>


    {{-- =========================================================
         DATOS DEL PERIODO
         ========================================================= --}}

    <table class="datos-periodo">

        <tr>

            <td class="etiqueta">
                PERIODO:
            </td>

            <td>
                {{ strtoupper($modelo['periodo']['tipo']) }}
            </td>

            <td class="etiqueta">
                FECHA:
            </td>

            <td>
                {{ \Carbon\Carbon::parse($modelo['periodo']['fecha_inicio'])->format('d/m/Y') }}
                al
                {{ \Carbon\Carbon::parse($modelo['periodo']['fecha_fin'])->format('d/m/Y') }}
            </td>

        </tr>

    </table>


    {{-- =========================================================
         TABLA GENERAL
         ========================================================= --}}

    <table class="tabla-general">

        <thead>

            <tr>

                <th class="col-orientador">
                    Orientador Fiscal
                </th>

                <th class="col-rif">
                    Personales<br>RIF
                </th>

                <th class="col-afluencias">
                    Total de<br>Afluencias
                </th>

                <th class="col-estatales">
                    Trámites<br>Estatales
                </th>

                <th class="col-requerimientos">
                    Requerimientos
                </th>

                <th class="col-otros">
                    Otros<br>Trámites
                </th>

                <th class="col-actividades">
                    Actividades realizadas<br>en el periodo
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($modelo['orientadores'] as $orientador)

                <tr>

                    <td class="texto-orientador">
                        {{ $orientador['orientador'] }}
                    </td>

                    <td class="numero">
                        {{ $orientador['rif']['personales'] }}
                    </td>

                    <td class="numero">
                        {{ $orientador['total_afluencias'] }}
                    </td>

                    <td class="numero">
                        {{ $orientador['tramites_estatales'] }}
                    </td>

                    <td class="numero">
                        {{ $orientador['requerimientos'] }}
                    </td>

                    <td class="otros">
                        {{ $orientador['otros_tramites'] }}
                    </td>

                    <td class="actividades">

                        @if(trim($orientador['actividades_adicionales'] ?? ''))

                            {!! nl2br(e($orientador['actividades_adicionales'])) !!}

                        @else

                            <span class="sin-actividades">
                                Sin actividades adicionales registradas.
                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="7"
                        style="text-align:center;"
                    >
                        No existen Orientadores Fiscales registrados.
                    </td>

                </tr>

            @endforelse


            {{-- =================================================
                 TOTAL GENERAL
                 ================================================= --}}

            <tr class="fila-total">

                <td>
                    TOTAL GENERAL
                </td>

                <td class="numero">
                    {{ $modelo['totales']['rif_personales'] }}
                </td>

                <td class="numero">
                    {{ $modelo['totales']['total_afluencias'] }}
                </td>

                <td class="numero">
                    {{ $modelo['totales']['tramites_estatales'] }}
                </td>

                <td class="numero">
                    {{ $modelo['totales']['requerimientos'] }}
                </td>

                <td class="otros">
                    Sin información
                </td>

                <td>
                    —
                </td>

            </tr>

        </tbody>

    </table>


    {{-- =========================================================
         FIRMA
         ========================================================= --}}

    <div class="firma">

        <div class="firma-linea"></div>

        <div class="firma-nombre">
            RESPONSABLE DEL ÁREA
        </div>

        <div class="firma-puesto">
            DEPARTAMENTO DE ASISTENCIA AL CONTRIBUYENTE
        </div>

    </div>

</body>
</html>