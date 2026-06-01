<div class="p-6">

    @if(session('success'))
        <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold">
            Trámites
        </h3>

        <button
            type="button"
            wire:click="abrirModal"
            style="background:#1f2937;color:white;padding:10px 16px;border-radius:6px;font-weight:bold;"
        >
            NUEVO TRÁMITE
        </button>
    </div>

    <div class="overflow-x-auto border rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Número</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Clasificación</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Trámite</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Declaración</th>
                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Activo</th>
                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tramites as $tramite)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $tramite->numero }}
                        </td>

                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $tramite->tipoTramite->nombre }}
                        </td>

                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $tramite->clasificacionTramite->nombre }}
                        </td>

                        <td class="px-4 py-2 text-sm text-gray-700 font-semibold">
                            {{ $tramite->nombre }}
                        </td>

                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $categorias[$tramite->categoria] ?? $tramite->categoria }}
                        </td>

                        <td class="px-4 py-2 text-sm text-center">
                            {{ $tramite->requiere_declaracion ? 'SÍ' : 'NO' }}
                        </td>

                        <td class="px-4 py-2 text-sm text-center">
                            @if($tramite->activo)
                                <span class="text-green-600 font-semibold">ACTIVO</span>
                            @else
                                <span class="text-red-600 font-semibold">INACTIVO</span>
                            @endif
                        </td>

                        <td class="px-4 py-2 text-sm text-right space-x-2">
                            <button
                                type="button"
                                wire:click="editar({{ $tramite->id }})"
                                class="text-blue-600 hover:text-blue-800 font-semibold"
                            >
                                Editar
                            </button>

                            <button
                                type="button"
                                wire:click="cambiarEstatus({{ $tramite->id }})"
                                class="text-orange-600 hover:text-orange-800 font-semibold"
                            >
                                {{ $tramite->activo ? 'Desactivar' : 'Activar' }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                            No existen trámites registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($modalAbierto)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold">
                        {{ $tramiteId ? 'Editar trámite' : 'Nuevo trámite' }}
                    </h3>
                </div>

                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Tipo de trámite
                            </label>

                            <select
                                wire:model.live="tipo_tramite_id"
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
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Clasificación
                            </label>

                            <select
                                wire:model="clasificacion_tramite_id"
                                class="w-full rounded-md border-gray-300"
                            >
                                <option value="">Seleccione...</option>

                                @foreach($clasificaciones as $clasificacion)
                                    @if($tipo_tramite_id === '' || (string) $clasificacion->tipo_tramite_id === (string) $tipo_tramite_id)
                                        <option value="{{ $clasificacion->id }}">
                                            {{ $clasificacion->numero }} - {{ $clasificacion->nombre }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>

                            @error('clasificacion_tramite_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-2">
                                Nombre
                            </label>

                            <input
                                type="text"
                                wire:model="nombre"
                                class="w-full rounded-md border-gray-300 uppercase"
                            >

                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Categoría
                            </label>

                            <select
                                wire:model="categoria"
                                class="w-full rounded-md border-gray-300"
                            >
                                <option value="">Seleccione...</option>

                                @foreach($categorias as $valor => $texto)
                                    <option value="{{ $valor }}">
                                        {{ $texto }}
                                    </option>
                                @endforeach
                            </select>

                            @error('categoria')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-3 pt-7">
                            <label class="inline-flex items-center gap-2">
                                <input
                                    type="checkbox"
                                    wire:model="requiere_declaracion"
                                >
                                <span>Requiere declaración / importe</span>
                            </label>

                            <br>

                            <label class="inline-flex items-center gap-2">
                                <input
                                    type="checkbox"
                                    wire:model="activo"
                                >
                                <span>Activo</span>
                            </label>
                        </div>
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
                        style="background:#1f2937;color:white;padding:8px 16px;border-radius:6px;font-weight:bold;"
                    >
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>