<?php

use App\Models\Contribuyente;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $buscar = '';

    public int $perPage = 10;

    public function updatedBuscar(): void
    {
        $this->resetPage();
    }

    public function with(): array
    {
        $query = Contribuyente::query()
            ->when($this->buscar, function ($query) {
                $buscar = mb_strtoupper(trim($this->buscar), 'UTF-8');

                $query->where(function ($q) use ($buscar) {
                    $q->where('rfc', 'like', "%{$buscar}%")
                        ->orWhere('curp', 'like', "%{$buscar}%")
                        ->orWhere('razon_social', 'like', "%{$buscar}%")
                        ->orWhere('nombre', 'like', "%{$buscar}%")
                        ->orWhere('apellido_paterno', 'like', "%{$buscar}%")
                        ->orWhere('apellido_materno', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('razon_social');

        return [
            'contribuyentes' => $query->paginate($this->perPage),
        ];
    }
};
?>

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

                    <a href="#"
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
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    RFC
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    CURP
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Razón social
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Teléfono
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Estatus
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                    Acciones
                                </th>
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

                                    <td class="px-4 py-3 text-sm text-right">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                            Editar
                                        </a>
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