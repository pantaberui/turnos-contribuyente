<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Asesoria;
use App\Models\AsesoriaTramite;
use App\Models\Tramite;
use App\Models\AsesoriaContribuyente;
use App\Models\Contribuyente;

class AsesoriaConsulta extends Component
{
    use WithPagination;

    public ?int $asesoriaSeleccionadaId = null;
    public $asesoriaSeleccionada = null;
    public bool $mostrandoDetalle = false;

    public bool $editandoTramite = false;
    public ?int $tramiteDetalleId = null;
    public int $cantidad = 1;
    public $importe_declaracion = null;
    public $tramitesDisponibles = [];
    public ?int $tramite_id = null;
    public bool $tramiteRequiereDeclaracion = false;

    public bool $agregandoTramite = false;
    public ?int $nuevo_tramite_id = null;
    public ?int $nuevo_contribuyente_id = null;
    public int $nueva_cantidad = 1;
    public $nuevo_importe_declaracion = null;
    public bool $nuevoTramiteRequiereDeclaracion = false;

    public bool $agregandoContribuyente = false;
    public ?int $nuevo_contribuyente_asesoria_id = null;
    public $contribuyentesDisponibles = [];

    public function render()
    {
        $asesorias = Asesoria::query()
            ->with([
                'asesor',
                'contribuyentes.contribuyente',
                'tramites.tramite',
            ])
            ->latest()
            ->paginate(15);

        return view('livewire.asesoria-consulta', [
            'asesorias' => $asesorias,
        ]);
    }

    public function verDetalle(int $asesoriaId): void
    {
        $this->asesoriaSeleccionadaId = $asesoriaId;

        $this->cargarDetalle();

        $this->mostrandoDetalle = true;
    }

    public function cargarDetalle(): void
    {
        if (!$this->asesoriaSeleccionadaId) {
            return;
        }

        $this->asesoriaSeleccionada = Asesoria::with([
            'asesor',
            'contribuyentes.contribuyente',
            'tramites.tramite.tipoTramite',
            'tramites.tramite.clasificacionTramite',
            'tramites.contribuyente',
        ])->find($this->asesoriaSeleccionadaId);
    }

    public function cerrarDetalle(): void
    {
        $this->cancelarAgregarTramite();

        $this->asesoriaSeleccionadaId = null;
        $this->asesoriaSeleccionada = null;
        $this->mostrandoDetalle = false;

        $this->cancelarEdicionTramite();
    }

    public function editarTramite(int $detalleId): void
    {
        $detalle = AsesoriaTramite::findOrFail($detalleId);

        $this->tramiteDetalleId = $detalle->id;
        $this->cantidad = $detalle->cantidad;
        $this->importe_declaracion = $detalle->importe_declaracion;
        $this->tramite_id = $detalle->tramite_id;
        $this->tramitesDisponibles = Tramite::activos()
            ->with(['tipoTramite', 'clasificacionTramite'])
            ->orderBy('nombre')
            ->get();

        $this->tramiteRequiereDeclaracion = (bool) $detalle->tramite?->requiere_declaracion;
        $this->editandoTramite = true;
    }

    public function guardarTramite(): void
    {
        $this->validate([
            'tramite_id' => ['required', 'exists:tramites,id'],
            'cantidad' => ['required', 'integer', 'min:1'],
            'importe_declaracion' => ['nullable', 'numeric', 'min:0'],
        ], [
            'tramite_id.required' => 'El trámite es obligatorio.',
            'tramite_id.exists' => 'El trámite seleccionado no existe.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad debe ser al menos 1.',
            'importe_declaracion.numeric' => 'El importe debe ser numérico.',
            'importe_declaracion.min' => 'El importe no puede ser negativo.',
        ]);

        $detalle = AsesoriaTramite::findOrFail($this->tramiteDetalleId);
        $tramite = Tramite::findOrFail($this->tramite_id);

        if (!$tramite->requiere_declaracion) {
            $this->importe_declaracion = null;
        }

        $detalle->update([
            'tramite_id' => $this->tramite_id,
            'cantidad' => $this->cantidad,
            'importe_declaracion' => $this->importe_declaracion ?: null,
        ]);

        $this->cancelarEdicionTramite();
        $this->cargarDetalle();

        session()->flash('success', 'Trámite actualizado correctamente.');
    }

    public function cancelarEdicionTramite(): void
    {
        $this->editandoTramite = false;
        $this->tramiteDetalleId = null;
        $this->cantidad = 1;
        $this->importe_declaracion = null;
        $this->tramite_id = null;
        $this->tramitesDisponibles = [];
        $this->tramiteRequiereDeclaracion = false;

    }

    public function updatedTramiteId($value): void
    {
        $tramite = Tramite::find($value);

        $this->tramiteRequiereDeclaracion = (bool) ($tramite?->requiere_declaracion ?? false);

        if (!$this->tramiteRequiereDeclaracion) {
            $this->importe_declaracion = null;
        }
    }

    public function cambiarTramite($tramiteId): void
    {
        $this->tramite_id = $tramiteId ? (int) $tramiteId : null;

        $tramite = Tramite::find($this->tramite_id);

        $this->tramiteRequiereDeclaracion = (bool) ($tramite?->requiere_declaracion ?? false);

        if (!$this->tramiteRequiereDeclaracion) {
            $this->importe_declaracion = null;
        }
    }

    public function mostrarFormularioAgregarTramite(): void
    {
        $this->cancelarEdicionTramite();

        $this->agregandoTramite = true;

        $this->tramitesDisponibles = Tramite::activos()
            ->orderBy('nombre')
            ->get();

        $this->nuevo_tramite_id = null;
        $this->nuevo_contribuyente_id = $this->asesoriaSeleccionada?->contribuyentes->first()?->contribuyente_id;
        $this->nueva_cantidad = 1;
        $this->nuevo_importe_declaracion = null;
        $this->nuevoTramiteRequiereDeclaracion = false;
    }

    public function cambiarNuevoTramite($tramiteId): void
    {
        $this->nuevo_tramite_id = $tramiteId ? (int) $tramiteId : null;

        $tramite = Tramite::find($this->nuevo_tramite_id);

        $this->nuevoTramiteRequiereDeclaracion = (bool) ($tramite?->requiere_declaracion ?? false);

        if (!$this->nuevoTramiteRequiereDeclaracion) {
            $this->nuevo_importe_declaracion = null;
        }
    }

    public function guardarNuevoTramite(): void
    {
        $this->validate([
            'nuevo_tramite_id' => ['required', 'exists:tramites,id'],
            'nuevo_contribuyente_id' => ['required', 'exists:contribuyentes,id'],
            'nueva_cantidad' => ['required', 'integer', 'min:1'],
            'nuevo_importe_declaracion' => ['nullable', 'numeric', 'min:0'],
        ]);

        $tramite = Tramite::findOrFail($this->nuevo_tramite_id);

        AsesoriaTramite::create([
            'asesoria_id' => $this->asesoriaSeleccionadaId,
            'contribuyente_id' => $this->nuevo_contribuyente_id,
            'tramite_id' => $this->nuevo_tramite_id,
            'cantidad' => $this->nueva_cantidad,
            'importe_declaracion' => $tramite->requiere_declaracion
                ? $this->nuevo_importe_declaracion
                : null,
        ]);

        $this->cancelarAgregarTramite();
        $this->cargarDetalle();

        session()->flash('success', 'Trámite agregado correctamente.');
    }

    public function cancelarAgregarTramite(): void
    {
        $this->agregandoTramite = false;
        $this->nuevo_tramite_id = null;
        $this->nuevo_contribuyente_id = null;
        $this->nueva_cantidad = 1;
        $this->nuevo_importe_declaracion = null;
        $this->nuevoTramiteRequiereDeclaracion = false;
    }

    public function eliminarTramite(int $detalleId): void
    {
        $detalle = AsesoriaTramite::findOrFail($detalleId);

        $detalle->delete();

        if ($this->tramiteDetalleId === $detalleId) {
            $this->cancelarEdicionTramite();
        }

        $this->cancelarAgregarTramite();
        $this->cargarDetalle();

        session()->flash('success', 'Trámite eliminado correctamente.');
    }

    public function marcarContribuyentePrincipal(int $detalleId): void
    {
        $registro = AsesoriaContribuyente::findOrFail($detalleId);

        AsesoriaContribuyente::where('asesoria_id', $registro->asesoria_id)
            ->update(['es_principal' => false]);

        $registro->update([
            'es_principal' => true,
        ]);

        $this->cargarDetalle();

        session()->flash('success', 'Contribuyente principal actualizado correctamente.');
    }

    public function mostrarFormularioAgregarContribuyente(): void
    {
        $this->cancelarEdicionTramite();
        $this->cancelarAgregarTramite();

        $this->agregandoContribuyente = true;
        $this->nuevo_contribuyente_asesoria_id = null;

        $idsActuales = $this->asesoriaSeleccionada
            ? $this->asesoriaSeleccionada->contribuyentes->pluck('contribuyente_id')->toArray()
            : [];

        $this->contribuyentesDisponibles = Contribuyente::query()
            ->whereNotIn('id', $idsActuales)
            ->orderBy('razon_social')
            ->get();
    }

    public function guardarNuevoContribuyente(): void
    {
        $this->validate([
            'nuevo_contribuyente_asesoria_id' => ['required', 'exists:contribuyentes,id'],
        ], [
            'nuevo_contribuyente_asesoria_id.required' => 'Seleccione un contribuyente.',
        ]);

        $yaExiste = AsesoriaContribuyente::where('asesoria_id', $this->asesoriaSeleccionadaId)
            ->where('contribuyente_id', $this->nuevo_contribuyente_asesoria_id)
            ->exists();

        if ($yaExiste) {
            $this->addError('nuevo_contribuyente_asesoria_id', 'El contribuyente ya se encuentra asociado a esta asesoría.');
            return;
        }

        $ultimoOrden = AsesoriaContribuyente::where('asesoria_id', $this->asesoriaSeleccionadaId)
            ->max('orden') ?? 0;

        AsesoriaContribuyente::create([
            'asesoria_id' => $this->asesoriaSeleccionadaId,
            'contribuyente_id' => $this->nuevo_contribuyente_asesoria_id,
            'orden' => $ultimoOrden + 1,
            'es_principal' => false,
        ]);

        $this->cancelarAgregarContribuyente();
        $this->cargarDetalle();

        session()->flash('success', 'Contribuyente agregado correctamente.');
    }

    public function cancelarAgregarContribuyente(): void
    {
        $this->agregandoContribuyente = false;
        $this->nuevo_contribuyente_asesoria_id = null;
        $this->contribuyentesDisponibles = [];
    }

    public function eliminarContribuyente(int $registroId): void
    {
        $registro = AsesoriaContribuyente::findOrFail($registroId);

        $totalContribuyentes = AsesoriaContribuyente::where('asesoria_id', $registro->asesoria_id)->count();

        if ($totalContribuyentes <= 1) {
            session()->flash('error', 'La asesoría debe tener al menos un contribuyente asociado.');
            return;
        }

        $tieneTramites = AsesoriaTramite::where('asesoria_id', $registro->asesoria_id)
            ->where('contribuyente_id', $registro->contribuyente_id)
            ->exists();

        if ($tieneTramites) {
            session()->flash('error', 'No se puede eliminar el contribuyente porque tiene trámites asociados.');
            return;
        }

        $eraPrincipal = $registro->es_principal;
        $asesoriaId = $registro->asesoria_id;

        $registro->delete();

        if ($eraPrincipal) {
            $nuevoPrincipal = AsesoriaContribuyente::where('asesoria_id', $asesoriaId)
                ->orderBy('orden')
                ->first();

            if ($nuevoPrincipal) {
                $nuevoPrincipal->update([
                    'es_principal' => true,
                ]);
            }
        }

        $this->cancelarAgregarContribuyente();
        $this->cargarDetalle();

        session()->flash('success', 'Contribuyente eliminado correctamente.');
    }

}