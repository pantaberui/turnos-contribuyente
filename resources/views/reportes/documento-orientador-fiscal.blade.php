<x-app-layout>

    <style>

        @page {
            size: Letter;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        /* =========================================================
           CONTENEDOR GENERAL DEL REPORTE
           ========================================================= */

        .reporte-orientador {
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

        .no-print {
            width: 816px;
            margin: 0 auto 20px;
            padding: 16px 20px;
            background: #fff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .08);
            font-family: Arial, Helvetica, sans-serif;
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

        .boton-complementario {
            background: #0369a1;
            color: #fff;
        }

        .boton-pdf {
            background: #b91c1c;
            color: #fff;
            text-decoration: none;
            display: inline-block;
        }

        .estado-capturado {
            color: #15803d;
            font-size: 13px;
            font-weight: 600;
            padding-bottom: 8px;
        }

        .estado-pendiente {
            color: #6b7280;
            font-size: 13px;
            padding-bottom: 8px;
        }


        /* =========================================================
           HOJA DEL REPORTE
           ========================================================= */

        .pagina {
            width: 816px;
            min-height: 1056px;
            margin: 0 auto;
            padding: 45px 80px 40px;
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


        /* =========================================================
           MENSAJE INICIAL
           ========================================================= */

        .sin-reporte {
            margin-top: 100px;
            text-align: center;
            font-size: 13px;
        }


        /* =========================================================
           MODAL DATOS COMPLEMENTARIOS
           ========================================================= */

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 50;
            overflow-y: auto;
            background: rgba(0, 0, 0, .55);
        }

        .modal-contenedor {
            min-height: 100vh;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-contenido {
            width: 100%;
            max-width: 620px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .25);
            overflow: hidden;
        }

        .modal-encabezado {
            padding: 16px 20px;
            background: #0f172a;
            color: #fff;
        }

        .modal-encabezado-interno {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-titulo {
            font-size: 18px;
            font-weight: bold;
        }

        .modal-periodo {
            margin-top: 4px;
            color: #cbd5e1;
            font-size: 13px;
        }

        .modal-cerrar {
            border: none;
            background: transparent;
            color: #fff;
            font-size: 26px;
            cursor: pointer;
        }

        .modal-cuerpo {
            padding: 24px;
        }

        .modal-cuerpo label {
            display: block;
            margin-bottom: 7px;
            color: #374151;
            font-size: 14px;
            font-weight: bold;
        }

        .modal-cuerpo label span {
            color: #6b7280;
            font-weight: normal;
        }

        .modal-cuerpo textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            resize: vertical;
            font-family: Arial, Helvetica, sans-serif;
        }

        .modal-pie {
            padding: 14px 24px;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .boton-cancelar {
            background: #e5e7eb;
            color: #374151;
        }

        .boton-guardar {
            background: #0369a1;
            color: #fff;
        }


        /* =========================================================
           IMPRESIÓN
           ========================================================= */

        @media print {

            .no-print {
                display: none !important;
            }

            .reporte-orientador {
                padding: 0;
                background: #fff;
                min-height: auto;
            }

            .pagina {
                width: 816px;
                min-height: 1056px;
                margin: 0;
                padding: 45px 80px 40px;
                box-shadow: none;
            }

            .modal {
                display: none !important;
            }

        }

    </style>


    <div class="reporte-orientador">


        {{-- =====================================================
             FILTROS
             ===================================================== --}}

        @if ($modelo || $orientadorId || $esAdministrador)

        <div class="no-print">

            <form
                method="GET"
                action="{{ route('reportes.orientador-fiscal.documento') }}"
                class="filtros"
            >

                {{-- =================================================
                    SELECTOR DE ORIENTADOR
                    Solo Administrador
                    ================================================= --}}

                @if($esAdministrador)

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
                                Seleccione un Orientador Fiscal
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

                @endif


                {{-- =================================================
                    Fechas
                    ================================================= --}}

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


                {{-- =================================================
                    Filtrar
                    ================================================= --}}

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
                        href="{{ route('reportes.orientador-fiscal.pdf', array_filter([
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


                {{-- =================================================
                    Datos complementarios
                    ================================================= --}}

                @if($orientadorId)

                    <div>

                        <button
                            type="button"
                            class="boton boton-complementario"
                            onclick="abrirModalComplementarioOrientador()"
                        >
                            📝 Datos complementarios
                        </button>

                    </div>


                    @if($modelo['complementario_existe'] ?? false)

                        <span class="estado-capturado">
                            ✓ Capturado
                        </span>

                    @else

                        <span class="estado-pendiente">
                            Pendiente
                        </span>

                    @endif

                @endif

            </form>

        </div>

    @endif


        {{-- =====================================================
             DOCUMENTO
             ===================================================== --}}

        <div class="pagina">

            @if ($modelo)

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
                        REPORTE MENSUAL ORIENTADOR FISCAL
                    </div>

                    <div class="subtitulo">
                        ESTATALES Y RÉGIMEN DE INCORPORACIÓN FISCAL (RIF)
                    </div>

                </div>


                {{-- Datos generales --}}
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


                {{-- Afluencias --}}
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


                {{-- Totales --}}
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


                {{-- Actividades --}}
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


                {{-- Firma --}}
                <div class="firma">

                    <div class="firma-label">
                        FIRMA:
                    </div>

                    <div class="firma-linea"></div>

                    <div class="firma-nombre">
                        ({{ $modelo['consulta']['orientador'] }})
                    </div>

                </div>


            @else

                <div class="sin-reporte">
                    Seleccione un Orientador Fiscal y un periodo para consultar el reporte.
                </div>

            @endif

        </div>


        {{-- =====================================================
             MODAL DATOS COMPLEMENTARIOS
             ===================================================== --}}

        @if($orientadorId)

            <div
                id="modal-complementario-orientador"
                class="modal"
            >

                <div class="modal-contenedor">

                    <div
                        class="modal-contenido"
                        onclick="event.stopPropagation()"
                    >

                        {{-- Encabezado --}}
                        <div class="modal-encabezado">

                            <div class="modal-encabezado-interno">

                                <div>

                                    <div class="modal-titulo">
                                        Información complementaria
                                    </div>

                                    <div class="modal-periodo">

                                        Reporte del
                                        {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }}
                                        al
                                        {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}

                                    </div>

                                </div>


                                <button
                                    type="button"
                                    class="modal-cerrar"
                                    onclick="cerrarModalComplementarioOrientador()"
                                >
                                    ×
                                </button>

                            </div>

                        </div>


                        {{-- Formulario --}}
                        <form
                            method="POST"
                            action="{{ route('reportes.orientador-fiscal.complementario.guardar') }}"
                        >

                            @csrf

                            <input
                                type="hidden"
                                name="orientador_id"
                                value="{{ $orientadorId }}"
                            >

                            <input
                                type="hidden"
                                name="fecha_inicio"
                                value="{{ $fechaInicio }}"
                            >

                            <input
                                type="hidden"
                                name="fecha_fin"
                                value="{{ $fechaFin }}"
                            >

                            <input
                                type="hidden"
                                name="tipo_periodo"
                                value="Mensual"
                            >


                            <div class="modal-cuerpo">

                                <label for="actividades_adicionales">

                                    Actividades realizadas en el mes

                                    <span>
                                        (funciones adicionales)
                                    </span>

                                </label>


                                <textarea
                                    id="actividades_adicionales"
                                    name="actividades_adicionales"
                                    rows="8"
                                    maxlength="3000"
                                    placeholder="Describa las actividades adicionales realizadas durante el periodo..."
                                >{{ old('actividades_adicionales', $modelo['actividades_adicionales'] ?? '') }}</textarea>

                            </div>


                            {{-- Botones --}}
                            <div class="modal-pie">

                                <button
                                    type="button"
                                    class="boton boton-cancelar"
                                    onclick="cerrarModalComplementarioOrientador()"
                                >
                                    Cancelar
                                </button>

                                <button
                                    type="submit"
                                    class="boton boton-guardar"
                                >
                                    Guardar información
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        @endif


    </div>


    {{-- =========================================================
         JAVASCRIPT
         ========================================================= --}}

    <script>

        function abrirModalComplementarioOrientador() {

            const modal = document.getElementById(
                'modal-complementario-orientador'
            );

            if (!modal) {
                return;
            }

            modal.style.display = 'block';

        }


        function cerrarModalComplementarioOrientador() {

            const modal = document.getElementById(
                'modal-complementario-orientador'
            );

            if (!modal) {
                return;
            }

            modal.style.display = 'none';

        }


        document.addEventListener('keydown', function (event) {

            if (event.key === 'Escape') {

                cerrarModalComplementarioOrientador();

            }

        });


        document.addEventListener('click', function (event) {

            const modal = document.getElementById(
                'modal-complementario-orientador'
            );

            if (modal && event.target === modal) {

                cerrarModalComplementarioOrientador();

            }

        });

    </script>

</x-app-layout>