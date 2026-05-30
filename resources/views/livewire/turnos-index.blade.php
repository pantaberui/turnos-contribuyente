<div class="p-6">

    <div class="bg-white rounded-lg shadow">

        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold">
                Turnos del día
            </h3>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">Turno</th>
                        <th class="px-4 py-3 text-left">Contribuyente</th>
                        <th class="px-4 py-3 text-left">Hora</th>
                        <th class="px-4 py-3 text-left">Estatus</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">

                    @forelse($turnos as $turno)

                        <tr>
                            <td class="px-4 py-3">
                                {{ $turno->folio }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $turno->contribuyente->razon_social }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $turno->hora_generado }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $turno->estatusTurno->nombre }}
                            </td>

                            <td class="px-4 py-3 text-right">
                                @if($turno->estatus_turno_id == 1)
                                    <button
                                        type="button"
                                        wire:click="llamarTurno({{ $turno->id }})"
                                        style="background:#1f2937;color:white;padding:8px 14px;border-radius:6px;font-weight:bold;"
                                    >
                                        Llamar
                                    </button>
                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                                No hay turnos para mostrar.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>