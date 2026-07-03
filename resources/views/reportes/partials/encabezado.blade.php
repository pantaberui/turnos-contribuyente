<div class="encabezado-documento">

    <div class="encabezado-superior">

        <div class="encabezado-logo">
            <img
                src="{{ asset('images/institucional/logo-finanzas-nayarit.png') }}"
                alt="Secretaría de Administración y Finanzas">
        </div>

        <div class="encabezado-reporte">

                <div class="dependencia">
                    DEPARTAMENTO DE ASISTENCIA AL CONTRIBUYENTE
                </div>

                <h1>
                    {{ $reporte->encabezado['reporte']['nombre'] }}
                </h1>

                <p>
                    {{ $reporte->encabezado['reporte']['subtitulo'] }}
                </p>

        </div>

    </div>

    <div class="encabezado-filtros">

        <div>
            <strong>ASESOR:</strong>
            {{ $reporte->encabezado['consulta']['asesor'] }}
        </div>

        <div>
            <strong>PERÍODO:</strong>
            {{ \Carbon\Carbon::parse($reporte->encabezado['periodo']['fecha_inicio'])->format('d/m/Y') }}
            -
            {{ \Carbon\Carbon::parse($reporte->encabezado['periodo']['fecha_fin'])->format('d/m/Y') }}
        </div>

        <div>
            <strong>MODALIDAD:</strong>
            {{ $reporte->encabezado['consulta']['modalidad'] }}
        </div>

        <div>
            <strong>MÓDULO:</strong>
            {{ $reporte->encabezado['modulo'] ?? 'TEPIC' }}
        </div>

    </div>

</div>