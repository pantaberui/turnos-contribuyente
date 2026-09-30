<x-app-layout>

    <style>

        @page {
            size: Letter;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        .reporte-general-orientadores {
            margin: 0;
            padding: 35px 0;
            background: #f5f5f5;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #000;
            min-height: calc(100vh - 64px);
        }


        /* =========================================================
           PANEL DE CONSULTA
           ========================================================= */

        .panel-filtros {
            width: 1000px;
            margin: 0 auto 20px;
            padding: 16px 20px;
            background: #fff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .08);
        }

        .filtros {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            align-items: end;
        }

        .filtro {
            display: flex;
            flex-direction: column;
        }

        .filtro label {
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
            font-weight: bold;
        }

        .filtro input[type="date"] {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 8px 10px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .boton {
            border: none;
            padding: 9px 18px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            white-space: nowrap;
            font-family: Arial, Helvetica, sans-serif;
        }

        .boton-filtrar {
            background: #1f2937;
            color: #fff;
        }

        .boton-pdf {
            background: #b91c1c;
            color: #fff;
            text-decoration: none;
            display: inline-block;
        }


        /* =========================================================
           HOJA DEL REPORTE
           ========================================================= */

        .pagina {
            width: 1000px;
            min-height: 1056px;
            margin: 0 auto;
            padding: 45px 55px 40px;
            background: #fff;
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
           TABLA GENERAL
           ========================================================= */

        .tabla-general {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
            table-layout: fixed;
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
            min-height: 48px;
            padding: 7px 6px;
            vertical-align: middle;
            font-size: 10px;
        }

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


        /* =========================================================
           SIN DATOS
           ========================================================= */

        .sin-reporte {
            margin-top: 100px;
            text-align: center;
            font-size: 13px;
        }


        /* =========================================================
           IMPRESIÓN
           ========================================================= */

        @media print {

            .panel-filtros {
                display: none !important;
            }

            .reporte-general-orientadores {
                padding: 0;
                background: #fff;
                min-height: auto;
            }

            .pagina {
                width: 1000px;
                min-height: 1056px;
                margin: 0;
                padding: 45px 55px 40px;
            }

        }

    </style>


    <div class="reporte-general-orientadores">


        {{-- =====================================================
             FILTROS
             ===================================================== --}}

        <div class="panel-filtros">

            <form
                method="GET"
                action="{{ route('reportes.general-orientadores.documento') }}"
                class="filtros"
            >
                <div class="filtro">

                    <label for="orientador_id">
                        Orientador Fiscal
                    </label>

                    <select
                        id="orientador_id"
                        name="orientador_id"
                        style="
                            border: 1px solid #d1d5db;
                            border-radius: 6px;
                            padding: 8px 38px 8px 12px;
                            width: 320px;
                            min-width: 320px;
                            font-family: Arial, Helvetica, sans-serif;
                            background-color: #fff;
                        "
                    >

                        <option value="">
                            Todos los Orientadores Fiscales
                        </option>

                        @foreach($orientadores as $orientador)

                            <option
                                value="{{ $orientador->id }}"
                                @selected((int) $orientadorId === (int) $orientador->id)
                            >
                                {{ $orientador->nombre_completo }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="filtro">

                    <label for="fecha_inicio">
                        Fecha inicio
                    </label>

                    <input
                        id="fecha_inicio"
                        type="date"
                        name="inicio"
                        value="{{ $fechaInicio }}"
                    >

                </div>


                <div class="filtro">

                    <label for="fecha_fin">
                        Fecha fin
                    </label>

                    <input
                        id="fecha_fin"
                        type="date"
                        name="fin"
                        value="{{ $fechaFin }}"
                    >

                </div>


                <div>

                    <button
                        type="submit"
                        class="boton boton-filtrar"
                    >
                        🔎 Filtrar
                    </button>

                </div>

                <div>

                    <a
                        href="{{ route('reportes.general-orientadores.pdf', array_filter([
                            'orientador_id' => $orientadorId,
                            'inicio' => $fechaInicio,
                            'fin' => $fechaFin,
                        ], fn($valor) => $valor !== null && $valor !== '')) }}"
                        class="boton boton-pdf"
                        target="_blank"
                    >
                        📄 PDF
                    </a>

                </div>

            </form>

        </div>


        {{-- =====================================================
             DOCUMENTO
             ===================================================== --}}

        <div class="pagina">

            {{-- Encabezado --}}
            <div class="encabezado">

                <div class="logos">

                    <img
                        src="{{ asset('images/institucional/logo-finanzas-nayarit.png') }}"
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


            {{-- Datos del periodo --}}
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


            {{-- =================================================
                 TABLA
                 ================================================= --}}

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


            {{-- =================================================
                 FIRMA
                 ================================================= --}}

            <div class="firma">

                <div class="firma-linea"></div>

                <div class="firma-nombre">
                    RESPONSABLE DEL ÁREA
                </div>

                <div class="firma-puesto">
                    DEPARTAMENTO DE ASISTENCIA AL CONTRIBUYENTE
                </div>

            </div>

        </div>

    </div>

</x-app-layout>