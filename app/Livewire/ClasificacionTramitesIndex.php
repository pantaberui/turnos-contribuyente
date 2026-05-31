<?php

namespace App\Livewire;

use App\Models\ClasificacionTramite;
use App\Models\TipoTramite;
use Livewire\Component;
use Illuminate\Validation\Rule;

class ClasificacionTramitesIndex extends Component
{
    public bool $modalAbierto = false;
    public ?int $clasificacionTramiteId = null;

    public string $tipo_tramite_id = '';
    public string $nombre = '';
    public bool $activo = true;
    public string $numero = '';

    public function abrirModal(): void
    {
        $this->resetForm();
        $this->modalAbierto = true;
    }

    public function editar(int $id): void
    {
        $clasificacion = ClasificacionTramite::findOrFail($id);

        $this->clasificacionTramiteId = $clasificacion->id;
        $this->tipo_tramite_id = (string) $clasificacion->tipo_tramite_id;
        $this->nombre = $clasificacion->nombre;
        $this->activo = (bool) $clasificacion->activo;
        $this->numero = (string) $clasificacion->numero;

        $this->modalAbierto = true;
    }

    public function guardar(): void
    {
        $this->validate([
            'tipo_tramite_id' => ['required', 'exists:tipo_tramites,id'],

            'numero' => [
                'required',
                'integer',
                'min:1',

                Rule::unique('clasificacion_tramites', 'numero')
                    ->where(function ($query) {
                        return $query->where(
                            'tipo_tramite_id',
                            $this->tipo_tramite_id
                        );
                    })
                    ->ignore($this->clasificacionTramiteId),
            ],

            'nombre' => ['required', 'string', 'max:255'],
            'activo' => ['boolean'],

        ], [
            'tipo_tramite_id.required' => 'EL TIPO DE TRÁMITE ES OBLIGATORIO.',
            'numero.required' => 'EL NÚMERO ES OBLIGATORIO.',
            'numero.unique' => 'YA EXISTE UNA CLASIFICACIÓN CON ESE NÚMERO PARA ESTE TIPO DE TRÁMITE.',
            'nombre.required' => 'EL NOMBRE ES OBLIGATORIO.',
        ]);

        ClasificacionTramite::updateOrCreate(
            
            ['id' => $this->clasificacionTramiteId],
            [
                'tipo_tramite_id' => $this->tipo_tramite_id,
                'numero' => $this->numero,
                'nombre' => mb_strtoupper(trim($this->nombre), 'UTF-8'),
                'activo' => $this->activo,
            ]
        );

        session()->flash('success', 'CLASIFICACIÓN GUARDADA CORRECTAMENTE.');

        $this->cerrarModal();
    }

    public function cambiarEstatus(int $id): void
    {
        $clasificacion = ClasificacionTramite::findOrFail($id);

        $clasificacion->update([
            'activo' => ! $clasificacion->activo,
        ]);
    }

    public function cerrarModal(): void
    {
        $this->modalAbierto = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->clasificacionTramiteId = null;
        $this->tipo_tramite_id = '';
        $this->nombre = '';
        $this->activo = true;
        $this->numero = '';
    }

    public function render()
    {
        return view('livewire.clasificacion-tramites-index', [
            'clasificaciones' => ClasificacionTramite::with('tipoTramite')
                ->orderBy('tipo_tramite_id')
                ->orderBy('numero')
                ->get(),

            'tiposTramite' => TipoTramite::where('activo', true)
                ->orderBy('nombre')
                ->get(),
        ]);
    }
}

