<div class="p-6">

    <div class="bg-white rounded-lg shadow">

        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold">
                Asesoría Fiscal
            </h3>
        </div>

        <div class="p-6">
            @if($mensajeInfo)
                <div class="mb-4 rounded-md bg-yellow-50 border border-yellow-200 p-3 text-sm text-yellow-800">
                    {{ $mensajeInfo }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif


            @if($this->moduloAsignado)
                <div class="mb-4 rounded-lg border border-blue-200 bg-blue-50 p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-blue-700">
                                Módulo asignado
                            </p>
                            <p class="font-semibold text-lg">
                                {{ $this->moduloAsignado->nombre }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-blue-700">
                                Asesor
                            </p>
                            <p class="font-semibold">
                                {{ $this->moduloAsignado->asesor->nombre_completo }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif



            @if($this->turnoActual && ! $turnoCerrado)


                <div class="rounded-lg bg-green-50 border border-green-200 p-6">
                    <h4 class="font-semibold text-green-800">
                        Turno actual
                     </h4>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-green-700">Turno</p>
                            <p class="text-3xl font-bold">
                                {{ $this->turnoActual->folio }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-green-700">Llamados</p>
                            <p class="font-semibold">
                                {{ $this->turnoActual->numero_llamados }}/3
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-green-700">Hora inicio atención</p>
                            <p class="font-semibold">
                                {{ $this->turnoActual->hora_inicio_atencion ?? '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-green-700">Tiempo atención</p>
                            <p class="font-semibold">
                                {{ $this->tiempoAtencion }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-green-700">RFC</p>
                            <p class="font-semibold">
                                {{ $this->turnoActual->contribuyente->rfc }}
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

                    @if($this->turnoActual->contribuyentes->count() > 0)
                        <div class="mt-6 border rounded-lg bg-white p-4">
                            <h4 class="font-semibold text-gray-800 mb-3">
                                Contribuyentes del turno
                            </h4>

                            <div class="space-y-2">
                                @foreach($this->turnoActual->contribuyentes as $turnoContribuyente)
                                    <div class="{{ $turnoContribuyente->es_principal ? 'bg-green-100 text-green-900' : 'bg-blue-100 text-blue-900' }} px-4 py-3 font-semibold">

                                        {{ $turnoContribuyente->orden }}.
                                        {{ $turnoContribuyente->contribuyente->razon_social }}


                                        @if($turnoContribuyente->es_principal)
                                            <span class="ml-2 text-xs font-bold">
                                                PRINCIPAL
                                            </span>
                                        @else
                                            <span class="ml-2 text-xs font-bold">
                                                ADICIONAL
                                            </span>
                                        @endif

                                        <span class="ml-4 text-sm font-normal">
                                            RFC: {{ $turnoContribuyente->contribuyente->rfc }}
                                        </span>
                                    </div>



                                    @if($this->turnoActual && $this->turnoActual->estatus_turno_id == 2)

                                        <div class="mt-6 border rounded-lg bg-white p-6 space-y-4">

                                            <h4 class="text-lg font-semibold text-gray-800">
                                                Trámites atendidos
                                            </h4>

                                            @foreach($tiposTramite as $tipo)
                                                <div class="border rounded-lg">

                                                    <div class="bg-gray-100 px-4 py-3 font-semibold">
                                                        {{ $tipo->nombre }}
                                                    </div>

                                                    <div class="p-4 space-y-4">

                                                        @foreach($tipo->clasificaciones as $clasificacion)

                                                            <details wire:ignore.self class="border rounded-lg">
                                                                <summary class="cursor-pointer px-4 py-3 bg-gray-50 font-semibold">
                                                                    {{ $clasificacion->numero }} - {{ $clasificacion->nombre }}
                                                                </summary>

                                                                <div class="p-4 space-y-3">

                                                                    @forelse($clasificacion->tramites as $tramite)

                                                                        <div class="border rounded-md p-3">

                                                                            <div class="flex items-center gap-3 flex-wrap">

                                                                                <input
                                                                                    type="checkbox"
                                                                                    wire:click="toggleTramite({{ $turnoContribuyente->contribuyente_id }}, {{ $tramite->id }})"
                                                                                    @checked(isset($tramitesSeleccionados[$turnoContribuyente->contribuyente_id][$tramite->id]))
                                                                                >

                                                                                <span class="font-medium flex-1">
                                                                                    {{ $tramite->numero }} - {{ $tramite->nombre }}
                                                                                </span>

                                                                                @if(isset($tramitesSeleccionados[$turnoContribuyente->contribuyente_id][$tramite->id]))

                                                                                    <span class="text-sm text-gray-600">
                                                                                        Cant.
                                                                                    </span>

                                                                                    <input
                                                                                        type="number"
                                                                                        min="1"
                                                                                        wire:model="tramitesSeleccionados.{{ $turnoContribuyente->contribuyente_id }}.{{ $tramite->id }}.cantidad"
                                                                                        class="w-20 rounded-md border-gray-300 text-sm"
                                                                                    >

                                                                                    @if($tramite->requiere_declaracion)

                                                                                        <span class="text-sm text-gray-600">
                                                                                            Importe
                                                                                        </span>

                                                                                       <input
                                                                                            type="number"
                                                                                            step="0.01"
                                                                                            min="0"
                                                                                            wire:model="tramitesSeleccionados.{{ $turnoContribuyente->contribuyente_id }}.{{ $tramite->id }}.importe_declaracion"
                                                                                            placeholder="0.00"
                                                                                            class="w-32 rounded-md border-gray-300 text-right text-sm"
                                                                                        >

                                                                                    @endif

                                                                                @endif

                                                                            </div>

                                                                            <div class="mt-2 text-xs text-gray-500">
                                                                                {{ \App\Models\Tramite::CATEGORIAS[$tramite->categoria] ?? $tramite->categoria }}

                                                                                @if($tramite->requiere_declaracion)
                                                                                    · Requiere importe
                                                                                @endif
                                                                            </div>

                                                                        </div>


                                                                    @empty

                                                                        <div class="text-sm text-gray-500">
                                                                            No hay trámites registrados en esta clasificación.
                                                                        </div>

                                                                    @endforelse

                                                                </div>
                                                            </details>

                                                        @endforeach

                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>

                                    @endif

                                   
                                @endforeach
                            </div>
                        </div>
                    @endif


        




                    @if($this->turnoActual->estatus_turno_id == 2)
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



                    @if($this->turnoActual->estatus_turno_id == 7)
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

                    @if($this->turnoActual->estatus_turno_id == 7 && $this->turnoActual->numero_llamados < 3)
                        <button
                            type="button"
                            wire:click="llamarNuevamente"
                            style="background:#2563eb;color:white;padding:10px 20px;border-radius:6px;font-weight:bold;"
                        >
                            LLAMAR NUEVAMENTE
                        </button>
                    @endif                  

                    @if($this->turnoActual->estatus_turno_id == 7)
                        <div class="mt-4 flex justify-end">
                            <button
                                type="button"
                                wire:click="marcarNoSePresento"
                                wire:confirm="¿Deseas marcar este turno como NO SE PRESENTÓ?"
                                style="background:#b91c1c;color:white;padding:10px 20px;border-radius:6px;font-weight:bold;"
                            >
                                NO SE PRESENTÓ
                            </button>
                        </div>
                    @endif

                </div>



                @if(count($this->resumenAtencion))

                    <div class="mt-6 border rounded-lg bg-gray-50 p-4">

                        <h4 class="font-semibold text-lg mb-4">
                            Resumen de atención
                        </h4>

                        @foreach($this->resumenAtencion as $grupo)

                            <div class="mb-4">

                                <div class="font-semibold text-green-700">
                                    {{ $grupo['nombre'] }}
                                </div>

                                <ul class="mt-2 space-y-1">

                                    @foreach($grupo['tramites'] as $tramite)

                                        <li class="text-sm">

                                            • {{ $tramite['nombre'] }}

                                            (Cantidad:
                                            {{ $tramite['cantidad'] }}

                                            @if($tramite['importe'])
                                                | Importe:
                                                ${{ number_format($tramite['importe'], 2) }}
                                            @endif
                                            )

                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        @endforeach

                    </div>

                @endif


                @if($this->turnoActual->estatus_turno_id == 2)

                    <div class="mt-6 flex justify-center">
                        <button
                            type="button"
                            wire:click="finalizarAtencion"
                            {{-- wire:confirm="¿Desea finalizar la atención?" --}}
                            style="background:#15803d;color:white;padding:10px 20px;border-radius:6px;font-weight:bold;"
                        >
                            FINALIZAR ATENCIÓN
                        </button>
                    </div>

                @endif



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

@script
<script>
    $wire.on('scroll-top', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    $wire.on('reproducir-llamado', (event) => {
        const texto = event.texto;

        const mensaje = new SpeechSynthesisUtterance(texto);
        mensaje.lang = 'es-MX';
        mensaje.rate = 0.9;
        mensaje.pitch = 1;

        window.speechSynthesis.cancel();
        window.speechSynthesis.speak(mensaje);
    });
</script>
@endscript