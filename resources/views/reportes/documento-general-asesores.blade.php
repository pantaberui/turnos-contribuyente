<x-app-layout>
    <x-slot name="header">
        <div class="no-print">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Documento Reporte General Asesores
            </h2>
        </div>
    </x-slot>

    <div class="reportes-fondo space-y-8">

        {{-- Herramientas de consulta --}}
        <div class="bg-white border rounded-lg shadow-sm p-4 no-print">
            <h3 class="font-bold space-y-8">
                Parámetros de consulta
            </h3>

            @include('reportes.partials.filtros')
        </div>

        {{-- Documento --}}
        <div class="flex justify-center">
            <div class="documento-hoja space-y-5">
                @include('reportes.partials.encabezado')
                @include('reportes.partials.body')
            </div>
        </div>

    </div>
</x-app-layout>