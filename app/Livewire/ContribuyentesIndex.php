<?php

namespace App\Livewire;

use App\Models\Contribuyente;
use Livewire\Component;
use Livewire\WithPagination;

class ContribuyentesIndex extends Component
{
    use WithPagination;

    public string $buscar = '';

    public int $perPage = 10;
    
    public function cambiarEstatus(int $contribuyenteId): void
    {
        $contribuyente = Contribuyente::findOrFail($contribuyenteId);

        $nuevoEstatus = ! $contribuyente->activo;

        $contribuyente->update([
            'activo' => $nuevoEstatus,
        ]);

        session()->flash(
            'success',
            $nuevoEstatus
                ? 'CONTRIBUYENTE ACTIVADO CORRECTAMENTE.'
                : 'CONTRIBUYENTE INACTIVADO CORRECTAMENTE.'
        );
    }

    public function updatedBuscar(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $contribuyentes = Contribuyente::query()
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
            ->orderBy('razon_social')
            ->paginate($this->perPage);

        return view('livewire.contribuyentes-index', [
            'contribuyentes' => $contribuyentes,
        ]);
    }
}
