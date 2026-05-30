<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Turno;

class TurnosIndex extends Component
{
    public function render()
    {
        return view('livewire.turnos-index', [
            'turnos' => Turno::query()
                ->with(['contribuyente', 'estatusTurno'])
                ->whereDate('fecha', now()->toDateString())
                ->orderBy('numero')
                ->get(),
        ]);
    }
    

    public function llamarTurno(int $turnoId): void
    {
        $turno = Turno::findOrFail($turnoId);

        $turno->update([
            'estatus_turno_id' => 2,
            'hora_llamado' => now()->format('H:i:s'),
        ]);
    }
}