<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Turno;
use Illuminate\Support\Facades\Auth;
use App\Models\TipoTramite;
use App\Models\DetalleTramite;

class AsesoriaIndex extends Component
{
    public array $tramitesSeleccionados = [];

    public function toggleTramite(
        int $contribuyenteId,
        int $tramiteId
    ): void
    {
        if (isset($this->tramitesSeleccionados[$contribuyenteId][$tramiteId])) {

            unset(
                $this->tramitesSeleccionados[$contribuyenteId][$tramiteId]
            );

            return;
        }

        $this->tramitesSeleccionados[$contribuyenteId][$tramiteId] = [
            'cantidad' => 1,
            'importe_declaracion' => '',
        ];
    }

   public function getTurnoActualProperty()
    {
        return Turno::query()
            ->with([
                'contribuyente',
                'estatusTurno',
                'contribuyentes.contribuyente',
            ])
            ->where('asesor_id', Auth::id())
            ->whereDate('fecha', now()->toDateString())
            ->whereIn('estatus_turno_id', [2, 3])
            ->orderByDesc('id')
            ->first();
    }

    public function llamarSiguienteTurno(): void
    {
        if ($this->turnoActual) {
            return;
        }

        $turno = Turno::query()
            ->whereDate('fecha', now()->toDateString())
            ->where('estatus_turno_id', 1)
            ->orderBy('numero')
            ->first();

        if (! $turno) {
            session()->flash('info', 'NO HAY TURNOS PENDIENTES.');
            return;
        }

        $turno->update([
            'asesor_id' => Auth::id(),
            'estatus_turno_id' => 2,
            'hora_llamado' => now()->format('H:i:s'),
        ]);
    }
    public function iniciarAtencion(): void
    {
        $turno = $this->turnoActual;

        if (! $turno) {
            return;
        }

        $turno->update([
            'estatus_turno_id' => 3,
            'hora_inicio_atencion' => now()->format('H:i:s'),
        ]);
    }

    public function finalizarAtencion(): void
    {
        $turno = $this->turnoActual;

        if (! $turno) {
            return;
        }

        foreach ($this->tramitesSeleccionados as $contribuyenteId => $tramites) {
            foreach ($tramites as $tramiteId => $datos) {
                DetalleTramite::create([
                    'turno_id' => $turno->id,
                    'contribuyente_id' => $contribuyenteId,
                    'tramite_id' => $tramiteId,
                    'cantidad' => $datos['cantidad'] ?? 1,
                    'importe_declaracion' => $datos['importe_declaracion'] ?: null,
                ]);
            }
        }

        $turno->update([
            'estatus_turno_id' => 4,
            'hora_fin_atencion' => now()->format('H:i:s'),
        ]);

        $this->tramitesSeleccionados = [];

        session()->flash(
            'success',
            'ATENCIÓN FINALIZADA CORRECTAMENTE.'
        );
    }

    public function render()
    {
        return view('livewire.asesoria-index', [
            'tiposTramite' => TipoTramite::where('activo', true)
                ->with('clasificaciones.tramites')
                ->orderBy('id')
                ->get(),
        ]);
    }
}