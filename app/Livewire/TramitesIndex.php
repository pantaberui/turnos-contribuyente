<?php

namespace App\Livewire;

use App\Models\ClasificacionTramite;
use App\Models\TipoTramite;
use App\Models\Tramite;
use Illuminate\Validation\Rule;
use Livewire\Component;

class TramitesIndex extends Component
{
    public bool $modalAbierto = false;
    public ?int $tramiteId = null;

    public string $tipo_tramite_id = '';
    public string $clasificacion_tramite_id = '';
    public string $numero = '';
    public string $nombre = '';
    public string $categoria = '';
    public bool $requiere_declaracion = false;
    public bool $activo = true;

    public function abrirModal(): void
    {
        $this->resetForm();
        $this->modalAbierto = true;
    }

    public function editar(int $id): void
    {
        $tramite = Tramite::findOrFail($id);

        $this->tramiteId = $tramite->id;
        $this->tipo_tramite_id = (string) $tramite->tipo_tramite_id;
        $this->clasificacion_tramite_id = (string) $tramite->clasificacion_tramite_id;
        $this->numero = (string) $tramite->numero;
        $this->nombre = $tramite->nombre;
        $this->categoria = $tramite->categoria;
        $this->requiere_declaracion = (bool) $tramite->requiere_declaracion;
        $this->activo = (bool) $tramite->activo;

        $this->modalAbierto = true;
    }

    public function guardar(): void
    {
        $this->validate([
            'tipo_tramite_id' => ['required', 'exists:tipo_tramites,id'],
            'clasificacion_tramite_id' => ['required', 'exists:clasificacion_tramites,id'],
            'numero' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('tramites', 'numero')
                    ->where(function ($query) {
                        return $query->where(
                            'clasificacion_tramite_id',
                            $this->clasificacion_tramite_id
                        );
                    })
                    ->ignore($this->tramiteId),
            ],
            'nombre' => ['required', 'string', 'max:255'],
            'categoria' => ['required', Rule::in(array_keys(Tramite::CATEGORIAS))],
            'requiere_declaracion' => ['boolean'],
            'activo' => ['boolean'],
        ], [
            'tipo_tramite_id.required' => 'EL TIPO DE TRÁMITE ES OBLIGATORIO.',
            'clasificacion_tramite_id.required' => 'LA CLASIFICACIÓN ES OBLIGATORIA.',
            'numero.required' => 'EL NÚMERO ES OBLIGATORIO.',
            'numero.unique' => 'YA EXISTE UN TRÁMITE CON ESE NÚMERO PARA ESTA CLASIFICACIÓN.',
            'nombre.required' => 'EL NOMBRE ES OBLIGATORIO.',
            'categoria.required' => 'LA CATEGORÍA ES OBLIGATORIA.',
        ]);

        Tramite::updateOrCreate(
            ['id' => $this->tramiteId],
            [
                'tipo_tramite_id' => $this->tipo_tramite_id,
                'clasificacion_tramite_id' => $this->clasificacion_tramite_id,
                'numero' => $this->numero,
                'nombre' => mb_strtoupper(trim($this->nombre), 'UTF-8'),
                'categoria' => $this->categoria,
                'requiere_declaracion' => $this->requiere_declaracion,
                'activo' => $this->activo,
            ]
        );

        session()->flash('success', 'TRÁMITE GUARDADO CORRECTAMENTE.');

        $this->cerrarModal();
    }

    public function cambiarEstatus(int $id): void
    {
        $tramite = Tramite::findOrFail($id);

        $tramite->update([
            'activo' => ! $tramite->activo,
        ]);
    }

    public function cerrarModal(): void
    {
        $this->modalAbierto = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->tramiteId = null;
        $this->tipo_tramite_id = '';
        $this->clasificacion_tramite_id = '';
        $this->numero = '';
        $this->nombre = '';
        $this->categoria = '';
        $this->requiere_declaracion = false;
        $this->activo = true;
    }

    public function render()
    {
        return view('livewire.tramites-index', [
            'tramites' => Tramite::with(['tipoTramite', 'clasificacionTramite'])
                ->orderBy('tipo_tramite_id')
                ->orderBy('clasificacion_tramite_id')
                ->orderBy('numero')
                ->get(),

            'tiposTramite' => TipoTramite::where('activo', true)
                ->orderBy('nombre')
                ->get(),

            'clasificaciones' => ClasificacionTramite::where('activo', true)
                ->orderBy('tipo_tramite_id')
                ->orderBy('numero')
                ->get(),

            'categorias' => Tramite::CATEGORIAS,
        ]);
    }
}