<div class="p-6">

    <div class="bg-white rounded-lg shadow">

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
            

            @if ($mostrandoLlamada)

                <div class="mb-6 bg-white rounded-xl shadow-md border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">
                                📞 Nueva asesoría telefónica
                            </h2>
                            <p class="text-sm text-slate-500">
                                El tiempo iniciará cuando se confirme la atención de la llamada.
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="cancelarLlamada"
                            style="background:#dc2626; color:white; padding:8px 14px; border-radius:8px; font-weight:700;">
                            Cancelar
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700">
                                País de origen
                            </label>
                            <input
                                type="text"
                                wire:model.defer="paisOrigenLlamada"
                                oninput="this.value = this.value.toUpperCase()"
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm">
                            @error('paisOrigenLlamada')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">
                                Ciudad de origen
                            </label>
                            <input
                                type="text"
                                wire:model.defer="ciudadOrigenLlamada"
                                oninput="this.value = this.value.toUpperCase()"
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm">
                            @error('ciudadOrigenLlamada')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">
                                Teléfono de origen
                            </label>
                            <input
                                type="text"
                                wire:model.defer="telefonoOrigenLlamada"
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm">
                            @error('telefonoOrigenLlamada')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @if($contribuyenteLlamadaSeleccionado)
                        <div class="mt-4 rounded-lg border border-green-300 bg-green-50 p-4">
                            <div class="font-bold text-green-800">
                                CONTRIBUYENTE SELECCIONADO
                            </div>

                            <div class="mt-2 text-sm">
                                <strong>RFC:</strong> {{ $contribuyenteLlamadaSeleccionado['rfc'] }}
                                <br>
                                <strong>CURP:</strong> {{ $contribuyenteLlamadaSeleccionado['curp'] ?? '—' }}
                                <br>
                                <strong>Razón Social:</strong> {{ $contribuyenteLlamadaSeleccionado['razon_social'] }}
                            </div>
                        </div>

                        <div class="mt-4">
                            <button
                                type="button"
                                wire:click="iniciarLlamadaTelefonica"
                                style="background:#2563eb;color:white;padding:10px 20px;border-radius:6px;font-weight:bold;">
                                INICIAR LLAMADA
                            </button>
                        </div>
                    @endif


                    <div class="mb-6">
                        <h3 class="font-semibold text-slate-700 mb-3">
                            Identificación del contribuyente
                        </h3>

                        <div style="display:grid; grid-template-columns:220px 260px 1fr 130px; gap:16px; align-items:end;">
                            <div>
                                <label class="block text-sm font-semibold mb-1">RFC</label>
                                <input type="text" oninput="this.value = this.value.toUpperCase()"  wire:model.defer="buscarRfc" class="w-full rounded-md border-slate-300">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-1">CURP</label>
                                <input type="text" oninput="this.value = this.value.toUpperCase()" wire:model.defer="buscarCurp" class="w-full rounded-md border-slate-300">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-1">Nombre / Razón Social</label>
                                <input type="text" oninput="this.value = this.value.toUpperCase()" wire:model.defer="buscarNombre" class="w-full rounded-md border-slate-300">
                            </div>

                            <div>
                                <button
                                    type="button"
                                    wire:click="buscarContribuyente"
                                    style="background:#2563eb;color:white;padding:10px 18px;border-radius:8px;font-weight:700;width:100%;">
                                    🔍 Buscar
                                </button>
                            </div>
                        </div>
                    </div>




                </div>












            @endif


          




            @if (!$this->turnoActual && !$mostrandoLlamada && !$llamadaEnCurso && !$mostrandoCorreo && !$correoEnCurso)
                <div class="mb-4 flex gap-3">
                    <button
                        type="button"
                        wire:click="nuevaLlamada"
                        style="background:#059669; color:white; padding:12px 20px; border-radius:8px; font-weight:700;">
                        📞 Nueva llamada
                    </button>

                    <button
                        type="button"
                        wire:click="nuevoCorreo"
                        style="background:#7c3aed; color:white; padding:12px 20px; border-radius:8px; font-weight:700;">
                        📧 Nuevo correo
                    </button>
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
                                @foreach($this->contribuyentesAtencion as $turnoContribuyente)                                
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
            @else


                @if($llamadaEnCurso && $asesoriaTelefonicaActual)
                    <div class="mb-4 rounded-lg border border-blue-300 bg-blue-50 p-5">
                        <h3 class="font-bold text-blue-800">
                            📞 ASESORÍA TELEFÓNICA EN CURSO
                        </h3>

                        <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <strong>Contribuyente:</strong><br>
                                {{ $asesoriaTelefonicaActual->contribuyente->razon_social }}
                            </div>

                            <div>
                                <strong>RFC:</strong><br>
                                {{ $asesoriaTelefonicaActual->contribuyente->rfc }}
                            </div>

                            <div>
                                <strong>Teléfono origen:</strong><br>
                                {{ $asesoriaTelefonicaActual->telefono_origen_llamada }}
                            </div>

                            <div>
                                <strong>País:</strong><br>
                                {{ $asesoriaTelefonicaActual->pais_origen_llamada }}
                            </div>

                            <div>
                                <strong>Ciudad:</strong><br>
                                {{ $asesoriaTelefonicaActual->ciudad_origen_llamada }}
                            </div>

                            <div wire:poll.1s>
                                <strong>Tiempo:</strong><br>
                                {{ $asesoriaTelefonicaActual->inicio_atencion->diff(now())->format('%H:%I:%S') }}
                            </div>
                        </div>

                        <div class="mt-4 flex justify-between">
                            <button
                                type="button"
                                wire:click="mostrarAgregarContribuyente"
                                style="background:#2563eb;color:white;padding:8px 14px;border-radius:6px;font-weight:bold;">
                                + Agregar contribuyente
                            </button>
                        </div>
                    </div>



                   
                @else

                    @if($correoEnCurso && $asesoriaCorreoActual)
                        <div class="mb-4 rounded-lg border border-purple-300 bg-purple-50 p-5">
                            <h3 class="font-bold text-purple-800">
                                📧 ASESORÍA POR CORREO EN CURSO
                            </h3>

                            <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <strong>Correo origen:</strong><br>
                                    {{ $asesoriaCorreoActual->correo_origen }}
                                </div>
                                <div>
                                    <strong>Asunto:</strong><br>
                                    {{ $asesoriaCorreoActual->asunto_correo }}
                                </div>
                                <div>
                                    <strong>Recepción:</strong><br>
                                    {{ optional($asesoriaCorreoActual->fecha_hora_recepcion_correo)->format('d/m/Y H:i') }}
                                </div>
                                <div wire:poll.1s>
                                    <strong>Tiempo:</strong><br>

                                    {{ $asesoriaCorreoActual->inicio_atencion->diff(now())->format('%H:%I:%S') }}
                                </div>
                            </div>

                            <div class="mt-4 flex justify-between">
                                <button
                                    type="button"
                                    wire:click="mostrarAgregarContribuyente"
                                    style="background:#2563eb;color:white;padding:8px 14px;border-radius:6px;font-weight:bold;">
                                    + Agregar contribuyente
                                </button>

                                <button
                                    type="button"
                                    wire:click="finalizarCorreoElectronico"
                                    wire:confirm="¿Deseas finalizar esta asesoría por correo?"
                                    style="background:#15803d;color:white;padding:10px 20px;border-radius:6px;font-weight:bold;">
                                    FINALIZAR ASESORÍA
                                </button>
                            </div>
                        </div>
                    @endif



                    @if(!$llamadaEnCurso && !$correoEnCurso && !$this->turnoActual && !$mostrandoLlamada && !$mostrandoCorreo)
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
                @endif

            @endif



            @if ($mostrandoCorreo)
                <div class="mb-6 bg-white rounded-xl shadow-md border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">
                                📧 Nueva asesoría por correo electrónico
                            </h2>
                            <p class="text-sm text-slate-500">
                                Captura los datos del correo recibido.
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="cancelarCorreo"
                            style="background:#dc2626;color:white;padding:8px 14px;border-radius:8px;font-weight:700;">
                            Cancelar
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700">
                                Fecha y hora de recepción
                            </label>
                            <input
                                type="datetime-local"
                                wire:model.defer="fechaHoraRecepcionCorreo"
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm">
                            @error('fechaHoraRecepcionCorreo')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">
                                Correo origen
                            </label>
                            <input
                                type="email"
                                wire:model.defer="correoOrigen"
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm">
                            @error('correoOrigen')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">
                                Asunto
                            </label>
                            <input
                                type="text"
                                wire:model.defer="asuntoCorreo"
                                oninput="this.value = this.value.toUpperCase()"
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm">
                            @error('asuntoCorreo')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-slate-700">
                            Observaciones / respuesta otorgada
                        </label>
                        <textarea
                            rows="4"
                            wire:model.defer="observacionesCorreo"
                            oninput="this.value = this.value.toUpperCase()"
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm"></textarea>
                        @error('observacionesCorreo')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mt-6">
                        <h3 class="font-semibold text-slate-700 mb-3">
                            Identificación del contribuyente
                        </h3>

                        <div style="display:grid; grid-template-columns:220px 260px 1fr 130px; gap:16px; align-items:end;">
                            <div>
                                <label class="block text-sm font-semibold mb-1">RFC</label>
                                <input
                                    type="text"
                                    oninput="this.value = this.value.toUpperCase()"
                                    wire:model.defer="buscarRfc"
                                    class="w-full rounded-md border-slate-300">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-1">CURP</label>
                                <input
                                    type="text"
                                    oninput="this.value = this.value.toUpperCase()"
                                    wire:model.defer="buscarCurp"
                                    class="w-full rounded-md border-slate-300">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-1">Nombre / Razón Social</label>
                                <input
                                    type="text"
                                    oninput="this.value = this.value.toUpperCase()"
                                    wire:model.defer="buscarNombre"
                                    class="w-full rounded-md border-slate-300">
                            </div>

                            <div>
                                <button
                                    type="button"
                                    wire:click="buscarContribuyente"
                                    style="background:#2563eb;color:white;padding:10px 18px;border-radius:8px;font-weight:700;width:100%;">
                                    🔍 Buscar
                                </button>
                            </div>
                        </div>
                    </div>


                    @if($contribuyenteLlamadaSeleccionado)
                        <div class="mt-4 rounded-lg border border-green-300 bg-green-50 p-4">
                            <div class="font-bold text-green-800">
                                CONTRIBUYENTE SELECCIONADO
                            </div>

                            <div class="mt-2 text-sm">
                                <strong>RFC:</strong> {{ $contribuyenteLlamadaSeleccionado['rfc'] }}
                                <br>
                                <strong>CURP:</strong> {{ $contribuyenteLlamadaSeleccionado['curp'] ?? '—' }}
                                <br>
                                <strong>Razón Social:</strong> {{ $contribuyenteLlamadaSeleccionado['razon_social'] }}
                            </div>
                        </div>

                        <div class="mt-4">
                            <button
                                type="button"
                                wire:click="iniciarCorreoElectronico"
                                style="background:#7c3aed;color:white;padding:10px 20px;border-radius:6px;font-weight:bold;">
                                INICIAR ASESORÍA POR CORREO
                            </button>
                        </div>
                    @endif
                    
                </div>
            @endif

            @if($mostrandoAgregarContribuyente)
                <div class="mt-4 mb-4 rounded-lg border border-slate-300 bg-white p-4 shadow-sm">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-bold text-slate-800">
                            Agregar contribuyente a la asesoría
                        </h4>

                        <button
                            type="button"
                            wire:click="cancelarAgregarContribuyente"
                            style="background:#dc2626;color:white;padding:6px 12px;border-radius:6px;font-weight:bold;">
                            Cancelar
                        </button>
                    </div>

                    <div style="display:grid; grid-template-columns:220px 260px 1fr 130px; gap:16px; align-items:end;">
                        <div>
                            <label class="block text-sm font-semibold mb-1">RFC</label>
                            <input
                                type="text"
                                oninput="this.value = this.value.toUpperCase()"
                                wire:model.defer="buscarRfcAdicional"
                                class="w-full rounded-md border-slate-300">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">CURP</label>
                            <input
                                type="text"
                                oninput="this.value = this.value.toUpperCase()"
                                wire:model.defer="buscarCurpAdicional"
                                class="w-full rounded-md border-slate-300">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Nombre / Razón Social</label>
                            <input
                                type="text"
                                oninput="this.value = this.value.toUpperCase()"
                                wire:model.defer="buscarNombreAdicional"
                                class="w-full rounded-md border-slate-300">
                        </div>

                        <div>
                            <button
                                type="button"
                                wire:click="buscarContribuyenteAdicional"
                                style="background:#2563eb;color:white;padding:10px 18px;border-radius:8px;font-weight:700;width:100%;">
                                🔍 Buscar
                            </button>
                        </div>
                    </div>


                    @if(count($resultadosBusquedaAdicional))
                        <div class="overflow-x-auto mt-4">
                            <table class="min-w-full border rounded-lg overflow-hidden">
                                <thead class="bg-slate-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left">RFC</th>
                                        <th class="px-4 py-2 text-left">Razón Social</th>
                                        <th class="px-4 py-2 text-center">Acción</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($resultadosBusquedaAdicional as $resultado)
                                        <tr class="border-t">
                                            <td class="px-4 py-2">
                                                {{ $resultado['rfc'] }}
                                            </td>

                                            <td class="px-4 py-2">
                                                {{ $resultado['razon_social'] }}
                                            </td>

                                            <td class="px-4 py-2 text-center">
                                                <button
                                                    type="button"
                                                    wire:click="agregarContribuyenteAdicional({{ $resultado['id'] }})"
                                                    style="background:#16a34a;color:white;padding:6px 12px;border-radius:6px;">
                                                    Agregar
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif


            @if(count($resultadosBusqueda))
                <div class="overflow-x-auto mt-4">
                    <table class="min-w-full border rounded-lg overflow-hidden">

                        <thead class="bg-slate-100">
                            <tr>
                                <th class="px-4 py-2 text-left">RFC</th>
                                <th class="px-4 py-2 text-left">Razón Social</th>
                                <th class="px-4 py-2 text-center">Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($resultadosBusqueda as $resultado)
                                <tr class="border-t">
                                    <td class="px-4 py-2">
                                        {{ $resultado['rfc'] }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $resultado['razon_social'] }}
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <button
                                            wire:click="seleccionarContribuyente({{ $resultado['id'] }})"
                                            style="background:#16a34a;color:white;padding:6px 12px;border-radius:6px;">
                                            Seleccionar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif


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



            @if($this->asesoriaActual && count($this->contribuyentesAtencion))
                <div class="mt-6 border rounded-lg bg-white p-6 space-y-4">

                    <h4 class="text-lg font-semibold text-gray-800">
                        Trámites atendidos
                    </h4>

                    @foreach($this->contribuyentesAtencion as $turnoContribuyente)

                        <div class="{{ $turnoContribuyente->es_principal ? 'bg-green-100 text-green-900' : 'bg-blue-100 text-blue-900' }} px-4 py-3 font-semibold rounded">
                            {{ $turnoContribuyente->orden }}.
                            {{ $turnoContribuyente->contribuyente->razon_social }}

                            @if($turnoContribuyente->es_principal)
                                <span class="ml-2 text-xs font-bold">PRINCIPAL</span>
                            @else
                                <span class="ml-2 text-xs font-bold">ADICIONAL</span>
                            @endif

                            <span class="ml-4 text-sm font-normal">
                                RFC: {{ $turnoContribuyente->contribuyente->rfc }}
                            </span>
                        </div>

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
                                                                <span class="text-sm text-gray-600">Cant.</span>

                                                                <input
                                                                    type="number"
                                                                    min="1"
                                                                    wire:model.defer="tramitesSeleccionados.{{ $turnoContribuyente->contribuyente_id }}.{{ $tramite->id }}.cantidad"
                                                                    class="w-20 rounded-md border-gray-300 text-sm"
                                                                >

                                                                @if($tramite->requiere_declaracion)
                                                                    <span class="text-sm text-gray-600">Importe</span>

                                                                    <input
                                                                        type="number"
                                                                        step="0.01"
                                                                        min="0"
                                                                        wire:model.defer="tramitesSeleccionados.{{ $turnoContribuyente->contribuyente_id }}.{{ $tramite->id }}.importe_declaracion"
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

                    @endforeach
                </div>
            @endif

            @if($correoEnCurso && $asesoriaCorreoActual)
                <div class="mt-6 flex justify-center">
                    <button
                        type="button"
                        wire:click="finalizarCorreoElectronico"
                        wire:confirm="¿Deseas finalizar esta asesoría por correo?"
                        style="background:#15803d;color:white;padding:10px 20px;border-radius:6px;font-weight:bold;">
                        FINALIZAR ASESORÍA POR CORREO
                    </button>
                </div>
            @endif


            @if($this->turnoActual && $this->turnoActual->estatus_turno_id == 2)

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


            @if($llamadaEnCurso && $asesoriaTelefonicaActual)
                <div class="mt-6 flex justify-center">
                    <button
                        type="button"
                        wire:click="finalizarLlamadaTelefonica"
                        wire:confirm="¿Deseas finalizar esta asesoría telefónica?"
                        style="background:#15803d;color:white;padding:10px 20px;border-radius:6px;font-weight:bold;">
                        FINALIZAR ASESORÍA TELEFÓNICA
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