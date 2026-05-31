<?php

namespace App\Livewire;

use App\Models\TipoTramite;
use Livewire\Component;

class TipoTramitesIndex extends Component
{
    public bool $modalAbierto = false;
    public ?int $tipoTramiteId = null;

    public string $nombre = '';
    public bool $activo = true;

    public function abrirModal(): void
    {
        $this->resetForm();
        $this->modalAbierto = true;
    }

    public function editar(int $id): void
    {
        $tipoTramite = TipoTramite::findOrFail($id);

        $this->tipoTramiteId = $tipoTramite->id;
        $this->nombre = $tipoTramite->nombre;
        $this->activo = (bool) $tipoTramite->activo;

        $this->modalAbierto = true;
    }

    public function guardar(): void
    {
        $this->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'activo' => ['boolean'],
        ], [
            'nombre.required' => 'EL NOMBRE ES OBLIGATORIO.',
        ]);

        TipoTramite::updateOrCreate(
            ['id' => $this->tipoTramiteId],
            [
                'nombre' => mb_strtoupper(trim($this->nombre), 'UTF-8'),
                'activo' => $this->activo,
            ]
        );

        session()->flash('success', 'TIPO DE TRÁMITE GUARDADO CORRECTAMENTE.');

        $this->cerrarModal();
    }

    public function cambiarEstatus(int $id): void
    {
        $tipoTramite = TipoTramite::findOrFail($id);

        $tipoTramite->update([
            'activo' => ! $tipoTramite->activo,
        ]);
    }

    public function cerrarModal(): void
    {
        $this->modalAbierto = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->tipoTramiteId = null;
        $this->nombre = '';
        $this->activo = true;
    }

    public function render()
    {
        return view('livewire.tipo-tramites-index', [
            'tiposTramite' => TipoTramite::orderBy('id')->get(),
        ]);
    }
}