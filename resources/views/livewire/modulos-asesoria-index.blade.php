<div class="max-w-7xl mx-auto p-6">

    @if($mensajeSuccess)
        <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-800">
            {{ $mensajeSuccess }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold">
            Módulos de asesoría
        </h3>

        <button
            type="button"
            wire:click="nuevo"
            style="background:#1f2937;color:white;padding:10px 16px;border-radius:6px;font-weight:bold;"
        >
            NUEVO MÓDULO
        </button>

    </div>

    <div class="overflow-x-auto border rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Asesor</th>
                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Activo</th>
                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($modulos as $modulo)
                    <tr>
                        <td class="px-4 py-2 text-sm font-semibold text-gray-700">
                            {{ $modulo->nombre }}
                        </td>

                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $modulo->descripcion ?? '—' }}
                        </td>

                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $modulo->estatusModulo->nombre ?? '—' }}
                        </td>

                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $modulo->asesor->name ?? 'SIN ASIGNAR' }}
                        </td>

                        <td class="px-4 py-2 text-sm text-center">
                            @if($modulo->activo)
                                <span class="text-green-600 font-semibold">ACTIVO</span>
                            @else
                                <span class="text-red-600 font-semibold">INACTIVO</span>
                            @endif
                        </td>

                        <td class="px-4 py-2 text-sm text-right space-x-2">
                            <button
                                type="button"
                                wire:click="editar({{ $modulo->id }})"
                                class="text-blue-600 hover:text-blue-800 font-semibold"
                            >
                                Editar
                            </button>

                            <button
                                type="button"
                                wire:click="cambiarEstatus({{ $modulo->id }})"
                                class="text-orange-600 hover:text-orange-800 font-semibold"
                            >
                                {{ $modulo->activo ? 'Desactivar' : 'Activar' }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            No existen módulos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($mostrarModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div
                style="
                    background:white;
                    width:900px;
                    max-width:90%;
                    margin:auto;
                    border-radius:10px;
                    box-shadow:0 10px 25px rgba(0,0,0,.25);
                "
            >

                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold">
                        {{ $moduloId ? 'Editar módulo' : 'Nuevo módulo' }}
                    </h3>
                </div>

                <div class="p-6 space-y-4">

                    <div>
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

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Descripción
                        </label>

                        <input
                            type="text"
                            wire:model="descripcion"
                            class="w-full rounded-md border-gray-300 uppercase"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Estatus del módulo
                        </label>

                        <select
                            wire:model="estatus_modulo_id"
                            class="w-full rounded-md border-gray-300"
                        >
                            <option value="">Seleccione...</option>

                            @foreach($estatuses as $estatus)
                                <option value="{{ $estatus->id }}">
                                    {{ $estatus->nombre }}
                                </option>
                            @endforeach
                        </select>

                        @error('estatus_modulo_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Asesor asignado
                        </label>

                        <select
                            wire:model="asesor_id"
                            class="w-full rounded-md border-gray-300"
                        >
                            <option value="">SIN ASIGNAR</option>

                            @foreach($asesores as $asesor)
                                <option value="{{ $asesor->id }}">
                                    {{ $asesor->name }}
                                </option>
                            @endforeach
                        </select>
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
                        style="background:#1f2937;color:white;padding:8px 16px;border-radius:6px;font-weight:bold;"
                    >
                        Guardar
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>