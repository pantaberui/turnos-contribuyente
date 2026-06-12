<div class="max-w-7xl mx-auto p-6">

    @if($mensajeSuccess)
        <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-800">
            {{ $mensajeSuccess }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold">
            Usuarios
        </h3>

        <button
            type="button"
            wire:click="nuevo"
            style="background:#1f2937;color:white;padding:10px 16px;border-radius:6px;font-weight:bold;"
        >
            NUEVO USUARIO
        </button>
    </div>

    <div class="w-full overflow-x-auto rounded-lg border border-slate-200">    
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nombre completo</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Correo</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Activo</th>
                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($usuarios as $usuario)
                    <tr>
                        <td class="px-4 py-2 text-sm font-semibold text-gray-700">
                            {{ $usuario->nombre_completo ?: $usuario->name }}
                        </td>

                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $usuario->email }}
                        </td>

                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $usuario->roles->first()?->name ?? 'SIN ROL' }}
                        </td>

                        <td class="px-4 py-2 text-center">
                            @if($usuario->activo)
                                <span class="text-green-600 font-semibold">ACTIVO</span>
                            @else
                                <span class="text-red-600 font-semibold">INACTIVO</span>
                            @endif
                        </td>

                        <td class="px-4 py-2 text-sm text-right space-x-2">
                            <button
                                type="button"
                                wire:click="editar({{ $usuario->id }})"
                                class="text-blue-600 hover:text-blue-800 font-semibold"
                            >
                                Editar
                            </button>

                            <button
                                type="button"
                                wire:click="cambiarEstatus({{ $usuario->id }})"
                                class="text-orange-600 hover:text-orange-800 font-semibold"
                            >
                                {{ $usuario->activo ? 'Desactivar' : 'Activar' }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                            No existen usuarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($mostrarModal)
        <div
            style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;z-index:9999;"
        >
            <div
                style="background:white;width:900px;max-width:90%;border-radius:10px;box-shadow:0 10px 25px rgba(0,0,0,.25);"
            >
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold">
                        {{ $usuarioId ? 'Editar usuario' : 'Nuevo usuario' }}
                    </h3>
                </div>

                <div class="p-6 space-y-4">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Nombre(s)</label>
                            <input type="text" wire:model="nombre" class="w-full rounded-md border-gray-300 uppercase">
                            @error('nombre') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Apellido paterno</label>
                            <input type="text" wire:model="apellido_paterno" class="w-full rounded-md border-gray-300 uppercase">
                            @error('apellido_paterno') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Apellido materno</label>
                            <input type="text" wire:model="apellido_materno" class="w-full rounded-md border-gray-300 uppercase">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Correo electrónico</label>
                        <input type="email" wire:model="email" class="w-full rounded-md border-gray-300">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Rol</label>
                        <select wire:model="role" class="w-full rounded-md border-gray-300">
                            <option value="">Seleccione...</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                            @endforeach
                        </select>
                        @error('role') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Contraseña {{ $usuarioId ? '(opcional)' : '' }}
                            </label>
                            <input type="password" wire:model="password" class="w-full rounded-md border-gray-300">
                            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Confirmar contraseña</label>
                            <input type="password" wire:model="password_confirmation" class="w-full rounded-md border-gray-300">
                        </div>
                    </div>

                    <div>
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" wire:model="activo">
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