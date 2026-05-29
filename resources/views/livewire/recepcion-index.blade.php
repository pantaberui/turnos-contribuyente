<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-sm rounded-lg">

            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold">
                    Recepción de contribuyentes
                </h2>
            </div>

            @if(! $this->asistenciaActiva && ! $this->turnoGenerado && ! $this->asistenciaFinalizadaSinTurno)
                <div class="p-6">
                    <button
                        type="button"
                        wire:click="iniciarAsistencia"
                        style="background:#1f2937; color:#ffffff; padding:10px 20px; border-radius:6px; font-weight:bold; text-transform:uppercase;"
                    >
                        Iniciar asistencia
                    </button>
                </div>
            @endif


            @if($this->asistenciaActiva )
               
                <div class="border rounded-lg bg-green-50 border-green-200 p-6">
                    <h3 class="text-lg font-semibold text-green-800 mb-4">
                        Asistencia activa #{{ $this->asistenciaActiva->numero_asistencia }}
                    </h3>

    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-green-700">Contribuyente</p>
                            <p class="font-semibold">                                
                                {{ $this->asistenciaActiva->contribuyente?->razon_social ?? 'SIN CONTRIBUYENTE ASIGNADO' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-green-700">RFC</p>
                            <p class="font-semibold">                                
                                {{ $this->asistenciaActiva->contribuyente?->rfc ?? '—' }}                              
                            </p>
                        </div>

                        @if(! $this->asistenciaActiva->contribuyente_id)
                            {{-- mostrar buscador de contribuyente --}}
                        @endif


                        <div>
                            <p class="text-sm text-green-700">Modalidad</p>
                            <p class="font-semibold">
                                {{ $this->asistenciaActiva->modalidad->nombre }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-green-700">Hora inicio</p>
                            <p class="font-semibold">
                                {{ $this->asistenciaActiva->hora_inicio }}
                            </p>
                        </div>

                        <div wire:poll.1s>
                            <p class="text-sm text-green-700">Tiempo transcurrido</p>
                            <p class="font-semibold text-lg">
                                {{ \Carbon\Carbon::parse($this->asistenciaActiva->hora_inicio)->diff(now())->format('%H:%I:%S') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-green-700">Estatus</p>
                            <p class="font-semibold">
                                EN RECEPCIÓN
                            </p>
                        </div>
                    </div>
                </div>



                @if($this->asistenciaActiva )            
                    @error('contribuyente')
                        <div class="rounded-md bg-red-50 border border-red-200 p-3 text-sm text-red-700">
                            {{ $message }}
                        </div>
                    @enderror

                    @if($this->asistenciaActiva && ! $this->asistenciaActiva->contribuyente_id)
                    <div>
                        <div class="mt-6 border rounded-lg bg-white p-6 space-y-4">
                            <h4 class="font-semibold text-gray-800">
                                Asignar contribuyente a la asistencia
                            </h4>
                            <label class="block text-sm font-medium mb-2">
                                Buscar contribuyente
                            </label>

                            <input
                                type="text"
                                wire:model.live.debounce.400ms="buscar"
                                placeholder="RFC, CURP O RAZÓN SOCIAL"
                                class="w-full rounded-md border-gray-300 uppercase"
                            >
                        </div>   
                    </div>
                    @endif

                    @if(strlen(trim($buscar)) > 0)
                        <div class="border rounded-lg divide-y">
                            @forelse($this->contribuyentes as $contribuyente)
                                <button
                                    type="button"
                                    wire:key="asistencia-contribuyente-{{ $contribuyente->id }}"
                                    wire:click="seleccionarContribuyenteParaAsistencia({{ $contribuyente->id }})"
                                    class="w-full text-left p-4 hover:bg-gray-50"
                                >
                                    <div class="font-semibold text-gray-800">
                                        {{ $contribuyente->razon_social }}
                                    </div>

                                    <div class="text-sm text-gray-500">
                                        RFC: {{ $contribuyente->rfc }}
                                    </div>
                                </button>
                            @empty
                                <div class="p-4 text-sm text-gray-500">
                                    No se encontraron contribuyentes.

                                    <div class="mt-3">
                                        <a href="{{ route('contribuyentes.create', ['return' => 'recepcion']) }}"
                                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md text-xs font-semibold uppercase">
                                            Registrar nuevo contribuyente
                                        </a>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    @endif
                    
                @endif


                <div class="mt-6 border rounded-lg bg-white p-6 space-y-6">

                    <h4 class="text-md font-semibold text-green-800">
                        Datos de la asistencia
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Tipo de trámite <span class="text-red-600">*</span>
                            </label>

                            <select
                                wire:model.blur="tipo_tramite_id"
                                class="w-full rounded-md border-gray-300"
                            >
                                <option value="">Seleccione...</option>

                                @foreach($tiposTramite as $tipoTramite)
                                    <option value="{{ $tipoTramite->id }}">
                                        {{ $tipoTramite->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_tramite_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                ¿Requiere turno?
                            </label>

                            <label class="inline-flex items-center gap-2 mt-2">
                                <input
                                    type="checkbox"
                                    wire:model.live="requiere_turno"
                                >

                                <span>Sí, requiere turno para asesoría</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Observaciones
                        </label>

                        <textarea
                            wire:model.blur="observaciones"
                            rows="3"
                            class="w-full rounded-md border-gray-300 uppercase"
                            placeholder="DESCRIPCIÓN BREVE DEL TRÁMITE O ASISTENCIA"
                        ></textarea>
                    </div>

                    <div class="border rounded-lg p-4 bg-white space-y-4">
                        <h4 class="font-semibold text-gray-800">
                            Contribuyentes adicionales
                        </h4>

                        @if($mensajeContribuyenteAdicional)
                            <div
                                wire:key="mensaje-adicional-{{ $mensajeContribuyenteAdicionalKey }}"
                                x-data="{ show: true }"
                                x-init="setTimeout(() => show = false, 4000)"
                                x-show="show"
                                x-transition
                                class="rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-800"
                            >
                                {{ $mensajeContribuyenteAdicional }}
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Buscar contribuyente adicional
                            </label>

                            <input
                                type="text"
                                wire:model.live.debounce.400ms="buscarContribuyenteAdicional"
                                placeholder="RFC, CURP O RAZÓN SOCIAL"
                                class="w-full rounded-md border-gray-300 uppercase"
                            >
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('contribuyentes.create', ['return' => 'recepcion']) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md text-xs font-semibold uppercase">
                                Registrar nuevo contribuyente
                            </a>
                        </div>

                        @if(strlen(trim($buscarContribuyenteAdicional)) >= 2)
                            <div class="border rounded-lg divide-y">
                                @forelse($this->contribuyentesAdicionales as $contribuyente)
                                    <button
                                        type="button"
                                        wire:key="adicional-{{ $contribuyente->id }}"
                                        wire:click="agregarContribuyenteAdicionalDesdeBD({{ $contribuyente->id }})"
                                        class="w-full text-left p-3 hover:bg-gray-50"
                                    >
                                        <div class="font-semibold text-gray-800">
                                            {{ $contribuyente->razon_social }}
                                        </div>

                                        <div class="text-sm text-gray-500">
                                            RFC: {{ $contribuyente->rfc }}
                                        </div>
                                    </button>
                                @empty
                                    <div class="p-4 text-sm text-gray-500">
                                        No se encontró el contribuyente.
                                    </div>
                                @endforelse
                            </div>
                        @endif

                        @if(count($lista_contribuyentes) > 0)
                            <div class="overflow-x-auto border rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                RFC
                                            </th>

                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                Nombre / Razón social
                                            </th>

                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($lista_contribuyentes as $index => $item)
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-700">
                                                    {{ $item['rfc'] ?: '—' }}
                                                </td>

                                                <td class="px-4 py-2 text-sm text-gray-700">
                                                    {{ $item['nombre'] ?: '—' }}
                                                </td>

                                                <td class="px-4 py-2 text-sm text-right">
                                                    <button
                                                        type="button"
                                                        wire:click="eliminarContribuyenteAdicional({{ $index }})"
                                                        wire:confirm="¿Deseas quitar este contribuyente de la lista?"
                                                        class="text-red-600 hover:text-red-900 font-semibold"
                                                    >
                                                        Quitar
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>


                    <div class="mt-6 flex justify-end">
                        <button
                            type="button"
                            wire:click="finalizarAsistencia"
                            style="background:#15803d;color:white;padding:10px 20px;border-radius:6px;font-weight:bold;"
                        >
                            FINALIZAR ASISTENCIA
                        </button>
                    </div>
                </div>
            @endif



            @if($asistenciaFinalizadaSinTurno)
                <div class="m-6 rounded-lg bg-green-50 border border-green-200 p-6">
                    <p class="text-green-700 font-semibold">
                        {{ $mensajeFinalizacion }}
                    </p>

                    <div class="mt-4">
                        <button
                            type="button"
                            wire:click="$set('asistenciaFinalizadaSinTurno', false)"
                            style="background:#1f2937;color:white;padding:10px 20px;border-radius:6px;font-weight:bold;"
                        >
                            Nueva asistencia
                        </button>
                    </div>
                </div>
            @endif

            @if($this->turnoGenerado)
                <div class="m-6 rounded-lg bg-blue-50 border border-blue-200 p-6">
                    <p class="text-blue-700 font-semibold">
                        ASISTENCIA FINALIZADA CORRECTAMENTE.
                    </p>

                    <p class="mt-2 text-sm text-blue-700">
                        Turno generado:
                    </p>

                    <p class="text-4xl font-bold text-blue-900">
                        {{ $this->turnoGenerado->folio }}
                    </p>

                    <div class="mt-4 flex gap-3">
                        <a href="{{ route('turnos.ticket', $this->turnoGenerado->id) }}"
                            target="_blank"
                            class="px-4 py-2 bg-blue-700 text-white rounded-md text-sm font-semibold">
                            Imprimir turno
                        </a>

                        <button
                            type="button"
                            wire:click="$set('turnoGeneradoId', null)"
                            class="px-4 py-2 bg-gray-200 rounded-md text-sm font-semibold">
                            Nueva asistencia
                        </button>
                    </div>
                </div>
            @endif




            @if(! $this->asistenciaActiva)
            <div class="p-6 space-y-6">

                {{-- Buscar --}}
                {{-- Resultados --}}

                @error('contribuyente')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror


                @if(strlen(trim($buscar)) > 0)
                <div class="border rounded-lg divide-y">

                    @forelse($this->contribuyentes as $contribuyente)
                    
                            <button
                                type="button"
                                wire:key="contribuyente-{{ $contribuyente->id }}"
                                
                                wire:click="seleccionarContribuyenteParaAsistencia({{ $contribuyente->id }})"
                                class="w-full text-left p-4 hover:bg-gray-50"
                            >
                            <div class="font-semibold text-gray-800">
                                {{ $contribuyente->razon_social }}
                            </div>

                            <div class="text-sm text-gray-500">
                                RFC: {{ $contribuyente->rfc }}
                            </div>
                        </button>

                    @empty
                        <div class="p-4 text-sm text-gray-500">
                            No se encontraron contribuyentes.

                            <div class="mt-3">
                                <a href="{{ route('contribuyentes.create', ['return' => 'recepcion']) }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md text-xs font-semibold uppercase">
                                    Registrar nuevo contribuyente
                                </a>
                            </div>
                        </div>

                    @endforelse

                </div>
                @endif


                @if($contribuyenteSeleccionado)
                <div class="mt-6 border rounded-lg bg-gray-50 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        Contribuyente seleccionado
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Razón Social</p>
                            <p class="font-semibold">{{ $contribuyenteSeleccionado->razon_social }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">RFC</p>
                            <p class="font-semibold">{{ $contribuyenteSeleccionado->rfc }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Teléfono</p>
                            <p class="font-semibold">{{ $contribuyenteSeleccionado->telefono_movil ?? '—' }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium mb-2">
                            Modalidad de atención
                        </label>

                        <select
                            wire:model="modalidad_id"
                            class="w-full md:w-1/3 rounded-md border-gray-300"
                        >
                            <option value="1">PRESENCIAL</option>
                            <option value="2">VIA TELEFONICA</option>
                            <option value="3">VIA CORREO ELECTRONICO</option>
                        </select>
                    </div>


                </div>
                @endif
            </div>
            @endif

        </div>

    </div>
</div>
