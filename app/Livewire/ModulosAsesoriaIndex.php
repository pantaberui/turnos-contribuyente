<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\ModuloAsesoria;
use App\Models\EstatusModulo;

class ModulosAsesoriaIndex extends Component
{
    public $moduloId;

    public $nombre = '';

    public $descripcion = '';

    public $estatus_modulo_id = '';

    public $asesor_id = '';

    public $activo = true;

    public bool $mostrarModal = false;
    public ?string $mensajeSuccess = null;

    public function nuevo(): void
    {
        $this->resetFormulario();
        $this->mostrarModal = true;
        $this->mensajeSuccess = null;
    }

    public function cerrarModal(): void
    {
        $this->mostrarModal = false;
    }

    private function resetFormulario(): void
    {
        $this->reset([
            'moduloId',
            'nombre',
            'descripcion',
            'estatus_modulo_id',
            'asesor_id',
        ]);

        $this->activo = true;
    }

    public function guardar(): void
    {
        $this->validate([
            'nombre' => ['required', 'max:100'],
            'estatus_modulo_id' => ['required'],
        ], [
            'nombre.required' => 'EL NOMBRE ES OBLIGATORIO.',
            'estatus_modulo_id.required' => 'EL ESTATUS ES OBLIGATORIO.',
        ]);

        ModuloAsesoria::updateOrCreate(
            ['id' => $this->moduloId],
            [
                'nombre' => mb_strtoupper(trim($this->nombre), 'UTF-8'),
                'descripcion' => $this->descripcion
                    ? mb_strtoupper(trim($this->descripcion), 'UTF-8')
                    : null,
                'estatus_modulo_id' => $this->estatus_modulo_id,
                'asesor_id' => $this->asesor_id ?: null,
                'activo' => $this->activo,
            ]
        );

        $this->cerrarModal();

        session()->flash(
            'success',
            'MÓDULO GUARDADO CORRECTAMENTE.'
        );
    }

    public function editar(int $id): void
    {
        $modulo = ModuloAsesoria::findOrFail($id);

        $this->moduloId = $modulo->id;
        $this->nombre = $modulo->nombre;
        $this->descripcion = $modulo->descripcion;
        $this->estatus_modulo_id = $modulo->estatus_modulo_id;
        $this->asesor_id = $modulo->asesor_id;
        $this->activo = $modulo->activo;
        $this->mensajeSuccess = null;
        $this->mostrarModal = true;
    }

    public function cambiarEstatus(int $id): void
    {
        $modulo = ModuloAsesoria::findOrFail($id);

        $modulo->update([
            'activo' => ! $modulo->activo,
        ]);
    }

    public function render()
    {
        return view('livewire.modulos-asesoria-index', [
            'modulos' => ModuloAsesoria::with([
                'estatusModulo',
                'asesor',
            ])
            ->orderBy('nombre')
            ->get(),

            'estatuses' => EstatusModulo::where('activo', true)
                ->orderBy('nombre')
                ->get(),

            'asesores' => User::orderBy('name')->get(),
        ]);
    }
}