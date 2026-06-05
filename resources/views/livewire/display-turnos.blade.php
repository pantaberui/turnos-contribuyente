<div wire:poll.keep-alive.5s class="min-h-screen bg-gray-900 text-white p-8">

    <div class="bg-white text-gray-900 rounded-2xl shadow-lg p-6 mb-8">
        <div class="flex items-center justify-center gap-8">

            <img
                src="{{ asset('images/institucional/logo-nayarit.png') }}"
                alt="Gobierno del Estado de Nayarit"
                class="h-16 object-contain mr-8"
            >

            <div class="text-center">

                <h1 class="text-3xl font-black uppercase text-gray-900">
                    GOBIERNO DEL ESTADO DE NAYARIT
                </h1>

                <p class="text-xl font-semibold text-gray-700 mt-1">
                    Secretaría de Administración y Finanzas
                </p>

                <p class="text-lg text-gray-600">
                    Departamento de Asistencia al Contribuyente
                </p>

            </div>

        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 bg-blue-700 rounded-3xl p-10 shadow-lg text-center">

            <p class="text-3xl uppercase font-semibold text-blue-100">
                Turno llamado
            </p>

            @if($turnoActual)

                <div class="mt-8 text-9xl font-black tracking-wider">
                    {{ $turnoActual->folio }}
                </div>

                <div class="mt-8 text-6xl font-bold bg-white text-blue-800 rounded-2xl py-6">
                    {{ $turnoActual->moduloAsesoria?->nombre ?? 'MÓDULO' }}
                </div>

            @else

                <div class="mt-12 text-5xl font-bold text-blue-100">
                    Esperando llamado
                </div>

            @endif

        </div>


        <div class="mt-8 bg-gray-800 rounded-3xl p-8 shadow-lg">

            <h2 class="text-3xl font-bold text-center mb-6 uppercase">
                Módulos en atención
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">

                @forelse($turnosEnAtencion as $turno)
                    <div class="bg-green-700 rounded-2xl p-6 text-center">
                        <div class="text-3xl font-bold">
                            {{ $turno->moduloAsesoria?->nombre ?? 'MÓDULO' }}
                        </div>

                        <div class="text-xl mt-2 text-green-100">
                            ATENDIENDO
                        </div>

                        <div class="text-5xl font-black mt-2">
                            {{ $turno->folio }}
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-400 text-2xl py-6 col-span-full">
                        No hay módulos en atención
                    </div>
                @endforelse

            </div>

        </div>




        <div class="bg-gray-800 rounded-3xl p-8 shadow-lg">

            <h2 class="text-3xl font-bold text-center mb-6 uppercase">
                Próximos turnos
            </h2>

            <div class="space-y-4">
                @forelse($proximosTurnos as $turno)
                    <div class="bg-gray-700 rounded-2xl p-6 text-center">
                        <span class="text-5xl font-bold">
                            {{ $turno->folio }}
                        </span>
                    </div>
                @empty
                    <div class="text-center text-gray-400 text-2xl py-10">
                        No hay turnos en espera
                    </div>
                @endforelse
            </div>

        </div>

    </div>

    <div class="mt-10 text-center text-gray-400 text-lg">
        Actualización automática
    </div>

</div>