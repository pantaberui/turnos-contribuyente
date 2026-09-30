<div class="reporte-seccion">

    <h2 class="documento-titulo-seccion">
        {{ $reporte->pie['actividades_label'] }}
    </h2>

    <div class="border border-gray-300 p-3 text-sm min-h-[90px]">

        @if(!empty($reporte->complementario['actividades_adicionales']))
            {!! nl2br(e($reporte->complementario['actividades_adicionales'])) !!}
        @else
            <span class="text-gray-500">
                Sin actividades adicionales registradas.
            </span>
        @endif

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