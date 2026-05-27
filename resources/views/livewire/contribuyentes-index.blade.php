<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            Contribuyentes
                        </h1>
                        <p class="text-sm text-gray-500">
                            Búsqueda por RFC, CURP, nombre o razón social.
                        </p>
                    </div>

                    <a href="{{ route('contribuyentes.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Nuevo contribuyente
                    </a>
                </div>

                <div class="mb-4">
                    <input
                        type="text"
                        wire:model.live.debounce.400ms="buscar"
                        placeholder="BUSCAR POR RFC, CURP, NOMBRE O RAZÓN SOCIAL"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 uppercase"
                    >
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">RFC</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">CURP</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Razón social</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teléfono</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($contribuyentes as $contribuyente)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ $contribuyente->rfc }}
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ $contribuyente->curp ?? '—' }}
                                    </td>

                                    <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                                        {{ $contribuyente->razon_social }}
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ $contribuyente->telefono_movil ?? '—' }}
                                    </td>

                                    <td class="px-4 py-3 text-sm">
                                        @if ($contribuyente->activo)
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                                ACTIVO
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                                INACTIVO
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-sm text-right space-x-3">

                                        <a href="{{ route('contribuyentes.show', $contribuyente) }}"
                                        class="text-sky-600 hover:text-sky-900">
                                            Ver
                                        </a>

                                        <a href="{{ route('contribuyentes.edit', $contribuyente) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                            Editar
                                        </a>

                                        <button
                                            type="button"
                                            wire:click="cambiarEstatus({{ $contribuyente->id }})"
                                            wire:confirm="¿Deseas cambiar el estatus del contribuyente?"
                                            class="{{ $contribuyente->activo
                                                ? 'text-red-600 hover:text-red-900'
                                                : 'text-green-600 hover:text-green-900' }}">
                                            {{ $contribuyente->activo ? 'Inactivar' : 'Activar' }}
                                        </button>

                                    </td>
                                    

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                        No se encontraron contribuyentes.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $contribuyentes->links() }}
                </div>

            </div>
        </div>

    </div>
</div>
