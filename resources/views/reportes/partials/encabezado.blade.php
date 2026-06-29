<div class="bg-white border rounded p-4 text-center">
    <img
        src="{{ asset('images/institucional/logo-finanzas-nayarit.png') }}"
        alt="Secretaría de Administración y Finanzas"
        style="height:70px; margin:auto;"
    >

    <h1 class="mt-3 text-lg font-bold">
        {{ $reporte['encabezado']['reporte']['nombre'] }}
    </h1>

    <h2 class="text-sm font-semibold">
        {{ $reporte['encabezado']['reporte']['subtitulo'] }}
    </h2>

    <div class="mt-3 inline-flex gap-6 bg-slate-100 border rounded px-4 py-2 text-sm">
        <div>
            <strong>ASESOR:</strong>
            {{ $reporte['encabezado']['consulta']['asesor'] ?? 'TODOS' }}
        </div>

        <div>
            <strong>MODALIDAD:</strong>
            {{ $reporte['encabezado']['consulta']['modalidad'] ?? 'TODAS' }}
        </div>
    </div>
</div>