<div class="p-6">
    <div class="bg-white rounded-lg shadow p-6">

        <table class="min-w-full border border-slate-200 text-sm">
            <thead class="bg-slate-100">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Modalidad</th>
                    <th class="px-4 py-2 text-left">Fecha</th>
                    <th class="px-4 py-2 text-left">Asesor</th>
                    <th class="px-4 py-2 text-left">Contribuyente (Principal)</th>
                    <th class="px-4 py-2 text-center">Contribuyentes</th>
                    <th class="px-4 py-2 text-center">Trámites</th>
                    <th class="px-4 py-2 text-center">Acción</th>
                </tr>
            </thead>

            <tbody>
                @foreach($asesorias as $asesoria)
                    <tr class="border-t hover:bg-slate-50">
                        <td class="px-4 py-2">
                            ASE-{{ str_pad($asesoria->id, 6, '0', STR_PAD_LEFT) }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $asesoria->modalidad }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $asesoria->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $asesoria->asesor?->nombre_completo ?? 'SIN ASESOR' }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $asesoria->contribuyentes->firstWhere('es_principal', true)?->contribuyente?->razon_social
                                ?? $asesoria->contribuyentes->first()?->contribuyente?->razon_social
                                ?? 'SIN CONTRIBUYENTE' }}
                        </td>

                        <td class="px-4 py-2 text-center">
                            {{ $asesoria->contribuyentes->count() }}
                        </td>

                        <td class="px-4 py-2 text-center">
                            {{ $asesoria->tramites->count() }}
                        </td>

                    
                        <td class="px-4 py-2 text-center">
                            <button
                                type="button"
                                wire:click="verDetalle({{ $asesoria->id }})"
                                style="background:#2563eb; color:white; padding:4px 12px; border-radius:6px;">
                                Ver
                            </button>
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($mostrandoDetalle && $asesoriaSeleccionada)
            <div class="mt-6 border rounded-lg bg-slate-50 p-5">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg">
                        Detalle de asesoría ASE-{{ str_pad($asesoriaSeleccionada->id, 6, '0', STR_PAD_LEFT) }}
                    </h3>

                    <button
                        type="button"
                        wire:click="cerrarDetalle"
                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded">
                        Cerrar
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <strong>Modalidad:</strong><br>
                        {{ $asesoriaSeleccionada->modalidad }}
                    </div>

                    <div>
                        <strong>Fecha:</strong><br>
                        {{ $asesoriaSeleccionada->created_at->format('d/m/Y H:i') }}
                    </div>

                    <div>
                        <strong>Asesor:</strong><br>
                        {{ $asesoriaSeleccionada->asesor?->nombre_completo ?? 'SIN ASESOR' }}
                    </div>
                </div>

                <h4 class="font-semibold mt-5 mb-2">Contribuyentes</h4>

                @forelse($asesoriaSeleccionada->contribuyentes as $item)
                    <div class="border rounded p-2 mb-2 bg-white text-sm">
                        {{ $item->orden }}.
                        {{ $item->contribuyente?->razon_social ?? 'SIN CONTRIBUYENTE' }}

                        @if($item->es_principal)
                            <span class="ml-2 font-bold text-green-700">
                                PRINCIPAL
                            </span>
                         @else
                            <button
                                type="button"
                                wire:click="marcarContribuyentePrincipal({{ $item->id }})"
                                style="background:#16a34a; color:white; padding:4px 10px; border-radius:6px; margin-left:8px;">
                                Marcar principal
                            </button>
                        @endif

                        <span class="ml-3">
                            RFC: {{ $item->contribuyente?->rfc ?? '—' }}
                        </span>
                    </div>
                @empty
                    <div class="text-sm text-slate-500">
                        Esta asesoría no tiene contribuyentes registrados.
                    </div>
                @endforelse

                <h4 class="font-semibold mt-5 mb-2">Trámites</h4>

                <div class="mb-3">
                    <button
                        type="button"
                        wire:click="mostrarFormularioAgregarTramite"
                        style="background:#2563eb; color:white; padding:6px 12px; border-radius:6px;">
                        Agregar trámite
                    </button>
                </div>

                @if($agregandoTramite)
                    <div class="border rounded p-3 mb-3 bg-white"
                        style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;">

                        <div style="width:1250px;">
                            <label class="block text-sm font-medium">Trámite</label>
                            <select
                                wire:model="nuevo_tramite_id"
                                wire:change="cambiarNuevoTramite($event.target.value)"
                                class="border rounded px-2 py-1"
                                style="width:100%;">
                                <option value="">Seleccione...</option>

                               @foreach($tramitesDisponibles as $tramite)
                                    <option value="{{ $tramite->id }}">
                                        [{{ $tramite->clasificacionTramite?->nombre ?? 'SIN CLASIFICACIÓN' }}]
                                        {{ $tramite->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div style="width:265px;">
                            <label class="block text-sm font-medium">Contribuyente</label>
                            <select
                                wire:model="nuevo_contribuyente_id"
                                class="border rounded px-2 py-1"
                                style="width:100%;">
                                <option value="">Seleccione...</option>

                                @foreach($asesoriaSeleccionada->contribuyentes as $item)
                                    <option value="{{ $item->contribuyente_id }}">
                                        {{ $item->contribuyente?->razon_social }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div style="width:100px;">
                            <label class="block text-sm font-medium">Cantidad</label>
                            <input
                                type="number"
                                min="1"
                                wire:model="nueva_cantidad"
                                class="border rounded px-2 py-1"
                                style="width:100%;">
                        </div>

                        @if($nuevoTramiteRequiereDeclaracion)
                            <div style="width:170px;">
                                <label class="block text-sm font-medium">Importe declaración</label>
                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    wire:model="nuevo_importe_declaracion"
                                    class="border rounded px-2 py-1"
                                    style="width:100%;">
                            </div>
                        @endif

                        <div style="display:flex; gap:8px;">
                            <button
                                type="button"
                                wire:click="guardarNuevoTramite"
                                style="background:#16a34a; color:white; padding:6px 12px; border-radius:6px;">
                                Guardar
                            </button>

                            <button
                                type="button"
                                wire:click="cancelarAgregarTramite"
                                style="background:#64748b; color:white; padding:6px 12px; border-radius:6px;">
                                Cancelar
                            </button>
                        </div>
                    </div>
                @endif

                @forelse($asesoriaSeleccionada->tramites as $detalle)
                    <div wire:key="tramite-detalle-{{ $detalle->id }}" class="border rounded p-3 mb-2 bg-white">
                        <div class="font-semibold">
                            {{ $detalle->tramite?->nombre ?? 'SIN TRÁMITE' }}
                        </div>

                        <div class="text-sm mt-1">
                            Tipo:
                            {{ $detalle->tramite?->tipoTramite?->nombre ?? '—' }}

                            |

                            Clasificación:
                            {{ $detalle->tramite?->clasificacionTramite?->nombre ?? '—' }}

                            |
                            
                            Contribuyente:
                            {{ $detalle->contribuyente?->razon_social ?? '—' }}

                            |

                            Cantidad:
                            {{ $detalle->cantidad }}

                            |

                            @if($tramiteRequiereDeclaracion)
                                |

                                Importe:
                                ${{ number_format($detalle->importe_declaracion ?? 0, 2) }}
                            @endif
                        </div>

                        <div class="mt-3">
                            @if(!$editandoTramite || $tramiteDetalleId !== $detalle->id)
                                <button
                                    type="button"
                                    wire:click="editarTramite({{ $detalle->id }})"
                                    style="background:#f59e0b; color:white; padding:4px 12px; border-radius:6px;">
                                    Editar
                                </button>

                                <button
                                    type="button"
                                    onclick="confirm('¿Está seguro de eliminar este trámite?') || event.stopImmediatePropagation()"
                                    wire:click="eliminarTramite({{ $detalle->id }})"
                                    style="background:#dc2626; color:white; padding:6px 12px; border-radius:6px; margin-left:6px;">
                                    Eliminar
                                </button>
                            @endif

                            @if($editandoTramite && $tramiteDetalleId === $detalle->id)
                                <span class="text-blue-600 text-sm font-semibold">
                                    Editando trámite...
                                </span>
                            @endif

                            @if($editandoTramite && $tramiteDetalleId === $detalle->id)
                                <div
                                    class="mt-3 border-t pt-3"
                                    style="display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;">

                                    <div style="width: 1250px;">
                                        <label class="block text-sm font-medium">Trámite</label>
                                        <select
                                            wire:model="tramite_id"
                                            wire:change="cambiarTramite($event.target.value)"
                                            class="border rounded px-2 py-1"
                                            style="width: 100%;">
                                            <option value="">Seleccione...</option>

                                            @foreach($tramitesDisponibles as $tramite)
                                                <option value="{{ $tramite->id }}">
                                                    [{{ $tramite->clasificacionTramite?->nombre ?? 'SIN CLASIFICACIÓN' }}]
                                                    {{ $tramite->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div style="width: 100px;">
                                        <label class="block text-sm font-medium">Cantidad</label>
                                        <input
                                            type="number"
                                            min="1"
                                            wire:model="cantidad"
                                            class="border rounded px-2 py-1"
                                            style="width: 100%;">
                                    </div>

                                    @if($tramiteRequiereDeclaracion)
                                        <div style="width: 170px;">
                                            <label class="block text-sm font-medium">Importe declaración</label>
                                            <input
                                                type="number"
                                                step="0.01"
                                                min="0"
                                                wire:model="importe_declaracion"
                                                class="border rounded px-2 py-1"
                                                style="width: 100%;">
                                        </div>
                                    @endif

                                    <div style="display: flex; gap: 8px;">
                                        <button
                                            type="button"
                                            wire:click="guardarTramite"
                                            style="background:#16a34a; color:white; padding:4px 12px; border-radius:6px;">
                                            Guardar
                                        </button>

                                        <button
                                            type="button"
                                            wire:click="cancelarEdicionTramite"
                                            style="background:#64748b; color:white; padding:4px 12px; border-radius:6px;">
                                            Cancelar
                                        </button>
                                    </div>

                                </div>
                            @endif


                        </div>
                    </div>
                @empty
                    <div class="text-sm text-slate-500">
                        Esta asesoría no tiene trámites registrados.
                    </div>
                @endforelse

            </div>
        @endif

        <div class="mt-4">
            {{ $asesorias->links() }}
        </div>

    </div>
</div>