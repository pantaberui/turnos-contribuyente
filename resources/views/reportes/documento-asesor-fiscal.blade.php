<x-app-layout>
    <x-slot name="header">
        @include('reportes.partials.encabezado')
    </x-slot>

    <div class="reportes-fondo space-y-8">

        {{-- Herramientas de consulta --}}
        <div class="bg-white border rounded-lg shadow-sm p-4">
            <h3 class="font-bold space-y-8">
                Parámetros de consulta
            </h3>

            @include('reportes.partials.filtros')
        </div>

        {{-- Documento --}}
        <div class="flex justify-center">
            <div class="documento-hoja space-y-5">

                @include('reportes.partials.informacion-consulta')

                @include('reportes.partials.totales')

                @foreach($reporte['secciones'] as $seccion)
                    @include('reportes.partials.seccion-tramites', [
                        'titulo' => $seccion['titulo'],
                        'seccion' => $seccion['contenido'],
                    ])
                @endforeach

                @include('reportes.partials.pie')

            </div>
        </div>

    </div>
</x-app-layout>