<div class="p-6">

    @if(session('success'))
        <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold">
            Clasificacíón de trámite
        </h3>

        <button
            type="button"
            wire:click="abrirModal"
            class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm font-semibold uppercase"
        >
            Nueva clasficación de trámite
        </button>
    </div>

    <div class="overflow-x-auto border rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                        Número
                    </th>

                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                        Tipo trámite
                    </th>

                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                        clasificación
                    </th>


                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                        Nombre
                    </th>

                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">
                        Activo
                    </th>

                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">
                        Acciones
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">

                @forelse($clasificaciones as $clasificacion)

                    <tr>

                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $clasificacion->numero }}
                        </td>

                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $clasificacion->tipoTramite->nombre }}
                        </td>

                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $clasificacion->nombre }}
                        </td>

                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $clasificacion->nombre }}
                        </td>

                        <td class="px-4 py-2 text-center">
                            @if($clasificacion->activo)
                                <span class="text-green-600 font-semibold">
                                    ACTIVO
                                </span>
                            @else
                                <span class="text-red-600 font-semibold">
                                    INACTIVO
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-2 text-right space-x-2">

                            <button
                                type="button"
                                wire:click="editar({{ $clasificacion->id }})"
                                class="text-blue-600 hover:text-blue-800 font-semibold"
                            >
                                Editar
                            </button>

                            <button
                                type="button"
                                wire:click="cambiarEstatus({{ $clasificacion->id }})"
                                class="text-orange-600 hover:text-orange-800 font-semibold"
                            >
                                {{ $clasificacion->activo ? 'Desactivar' : 'Activar' }}
                            </button>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                            No existen registros.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>

    {{-- Modal --}}
    @if($modalAbierto)

        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg">

                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold">
                        {{ $clasificacionTramiteId ? 'Editar clasificación de trámite' : 'Nueva clasificación de trámite' }}
                    </h3>
                </div>

                <div class="p-6 space-y-4">

                    <div>
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Tipo de trámite
                            </label>

                            <select
                                wire:model="tipo_tramite_id"
                                class="w-full rounded-md border-gray-300"
                            >
                                <option value="">Seleccione...</option>

                                @foreach($tiposTramite as $tipo)
                                    <option value="{{ $tipo->id }}">
                                        {{ $tipo->nombre }}
                                    </option>
                                @endforeach
                            </select>

                            @error('tipo_tramite_id')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Número
                            </label>

                            <input
                                type="number"
                                wire:model="numero"
                                min="1"
                                class="w-full rounded-md border-gray-300"
                            >

                            @error('numero')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>



                        <label class="block text-sm font-medium mb-2">
                            Nombre
                        </label>

                        <input
                            type="text"
                            wire:model="nombre"
                            class="w-full rounded-md border-gray-300 uppercase"
                        >

                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="inline-flex items-center gap-2">
                            <input
                                type="checkbox"
                                wire:model="activo"
                            >

                            <span>Activo</span>
                        </label>
                    </div>

                </div>

                <div class="px-6 py-4 border-t flex justify-end gap-2">

                    <button
                        type="button"
                        wire:click="cerrarModal"
                        class="px-4 py-2 bg-gray-200 rounded-md"
                    >
                        Cancelar
                    </button>

                    <button
                        type="button"
                        wire:click="guardar"
                        class="px-4 py-2 bg-gray-800 text-white rounded-md"
                    >
                        Guardar
                    </button>

                </div>

            </div>

        </div>

    @endif

</div>