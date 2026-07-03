<div class="bg-white border rounded p-4 mt-4">
    <h3 class="font-bold text-sm mb-3">
        {{ $reporte->pie['actividades_label'] }}
    </h3>

    <div class="border rounded min-h-[90px] p-3 text-sm text-gray-500">
        Pendiente de captura de actividades.
    </div>

    <div class="mt-8 text-center">
        <div class="border-t border-gray-700 w-72 mx-auto"></div>

        <div class="mt-2 text-sm font-semibold">
            {{ $reporte->pie['firma_label'] }}
        </div>

        <div class="mt-1 text-sm">
            {{ $reporte->pie['nombre_firma'] ?: '(NOMBRE DEL ASESOR RESPONSABLE)' }}
        </div>
    </div>
</div>