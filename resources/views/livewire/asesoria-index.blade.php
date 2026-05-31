<div class="p-6">

    <div class="bg-white rounded-lg shadow">

        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold">
                Asesoría Fiscal
            </h3>
        </div>

        <div class="p-6">
            @if (session('info'))
                <div class="mb-4 rounded-md bg-yellow-50 border border-yellow-200 p-3 text-sm text-yellow-800">
                    {{ session('info') }}
                </div>
            @endif

            @if($this->turnoActual)

                <div class="rounded-lg bg-green-50 border border-green-200 p-6">
                    <h4 class="font-semibold text-green-800">
                        Turno actual  verificar
                     </h4>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-green-700">Turno</p>
                            <p class="text-3xl font-bold">
                                {{ $this->turnoActual->folio }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-green-700">Contribuyente</p>
                            <p class="font-semibold">
                                {{ $this->turnoActual->contribuyente->razon_social }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-green-700">Estatus</p>
                            <p class="font-semibold">
                                {{ $this->turnoActual->estatusTurno->nombre }}
                            </p>
                        </div>
                    </div>

                    @if($this->turnoActual->estatus_turno_id == 3)
                        <div wire:poll.1s class="mt-4">
                            <p class="text-sm text-green-700">
                                Tiempo de atención
                            </p>

                            <p class="text-3xl font-bold">
                                {{
                                    \Carbon\Carbon::parse(
                                        $this->turnoActual->hora_inicio_atencion
                                    )->diff(now())->format('%H:%I:%S')
                                }}
                            </p>
                        </div>
                    @endif

                    @if($this->turnoActual->estatus_turno_id == 2)
                        <div class="mt-6 flex justify-end">
                            <button
                                type="button"
                                wire:click="iniciarAtencion"
                                style="background:#2563eb;color:white;padding:10px 20px;border-radius:6px;font-weight:bold;"
                            >
                                INICIAR ATENCIÓN
                            </button>
                        </div>
                    @endif

                </div>

            @else

                <div class="rounded-lg bg-gray-50 border p-6 text-center">
                    Ningún turno en atención
                </div>
                <div class="mt-6 flex justify-center">
                    <button
                        type="button"
                        wire:click="llamarSiguienteTurno"
                        style="background:#1f2937;color:white;padding:10px 20px;border-radius:6px;font-weight:bold;"
                    >
                        LLAMAR SIGUIENTE TURNO
                    </button>
                </div>

            @endif

        </div>

    </div>

</div>