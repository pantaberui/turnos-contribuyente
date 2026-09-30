<div class="max-w-7xl mx-auto p-6">

    <div class="mb-6">
        <h2 class="text-2xl font-bold">
            Resumen General del Día
        </h2>

        <p class="text-gray-500">
            {{ now()->format('d/m/Y') }}
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- RECEPCIÓN --}}
        <div class="bg-white rounded-xl shadow p-6">

            <h3 class="text-xl font-bold mb-4 border-b pb-2">
                Recepción / Orientación
            </h3>

            <div class="grid grid-cols-2 gap-4">

                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">
                        Asistencias hoy
                    </div>

                    <div class="text-3xl font-bold">
                        {{ $asistenciasHoy }}
                    </div>
                </div>

                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">
                        Orientaciones con turno
                    </div>

                    <div class="text-3xl font-bold">
                        {{ $orientacionesConTurno }}
                    </div>
                </div>

                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">
                        Orientaciones sin turno
                    </div>

                    <div class="text-3xl font-bold">
                        {{ $orientacionesSinTurno }}
                    </div>
                </div>

                <div class="bg-red-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">
                        Tiempo promedio de orientación
                    </div>

                    <div class="text-3xl font-bold">
                        {{ gmdate('i:s', $promedioOrientacion) }}
                    </div>
                </div>   


            </div>

        </div>

        {{-- ASESORÍA --}}
        <div class="bg-white rounded-xl shadow p-6">

            <h3 class="text-xl font-bold mb-4 border-b pb-2">
                Asesoría / Turnos
            </h3>

            <div class="grid grid-cols-2 gap-4">

                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">
                        Turnos generados
                    </div>

                    <div class="text-3xl font-bold">
                        {{ $turnosGenerados }}
                    </div>
                </div>

                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">
                        Turnos atendidos
                    </div>

                    <div class="text-3xl font-bold">
                        {{ $turnosAtendidos }}
                    </div>
                </div>

                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">
                        No se presentaron
                    </div>

                    <div class="text-3xl font-bold">
                        {{ $turnosNoPresentados }}
                    </div>
                </div>

                <div class="bg-red-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">
                        Tiempo promedio de atención
                    </div>

                    <div class="text-3xl font-bold">
                        {{ gmdate('i:s', $promedioAtencion) }}
                    </div>
                </div>

                <div class="bg-indigo-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">
                        En atención
                    </div>

                    <div class="text-3xl font-bold">
                        {{ $turnosEnAtencion }}
                    </div>
                </div>

                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">
                        Turnos pendientes
                    </div>

                    <div class="text-3xl font-bold">
                        {{ $turnosPendientes }}
                    </div>
                </div>

            </div>


        </div>

     

    </div>

    <div class="mt-6 bg-white rounded-xl shadow p-6">
        <h3 class="text-xl font-bold mb-4 border-b pb-2">
            Top asesores del día
        </h3>

        <div class="space-y-3">
            @forelse($topAsesores as $asesor)
                <div class="flex justify-between items-center border-b pb-2">
                    <span class="font-semibold">
                        {{ $asesor->asesor?->nombre_completo ?? 'SIN ASESOR' }}
                    </span>

                    <span class="text-lg font-bold">
                        {{ $asesor->total }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500">
                    No hay asesores con turnos atendidos hoy.
                </p>
            @endforelse
        </div>
    </div>

    <div class="mt-6 bg-white rounded-xl shadow p-6">
        <h3 class="text-xl font-bold mb-4 border-b pb-2">
            Top orientadores del día
        </h3>

        <div class="space-y-3">
            @forelse($topOrientadores as $orientador)
                <div class="flex justify-between items-center border-b pb-2">
                    <span class="font-semibold">
                        {{ $orientador->orientador?->nombre_completo ?? 'SIN ORIENTADOR' }}
                    </span>

                    <span class="text-lg font-bold">
                        {{ $orientador->total }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500">
                    No hay orientadores con asistencias hoy.
                </p>
            @endforelse
        </div>
    </div>

</div>