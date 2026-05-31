<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Turno;
use Illuminate\Support\Facades\Auth;

class AsesoriaIndex extends Component
{
    public function getTurnoActualProperty()
    {
        return Turno::query()
            ->with(['contribuyente', 'estatusTurno'])
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

    public function render()
    {
        return view('livewire.asesoria-index');
    }
}