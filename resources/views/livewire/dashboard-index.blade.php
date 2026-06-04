<div class="max-w-7xl mx-auto p-6">

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

                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">
                        Orientaciones sin turno
                    </div>

                    <div class="text-3xl font-bold">
                        {{ $orientacionesSinTurno }}
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

                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">
                        Turnos generados
                    </div>

                    <div class="text-3xl font-bold">
                        {{ $turnosGenerados }}
                    </div>
                </div>

                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">
                        Turnos atendidos
                    </div>

                    <div class="text-3xl font-bold">
                        {{ $turnosAtendidos }}
                    </div>
                </div>

                <div class="bg-red-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">
                        No se presentaron
                    </div>

                    <div class="text-3xl font-bold">
                        {{ $turnosNoPresentados }}
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

            </div>

        </div>

    </div>

</div>