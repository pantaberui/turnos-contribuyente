<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Turno;

class DisplayTurnos extends Component
{
    public function render()
    {
        return view('livewire.display-turnos', [
            'turnoActual' => Turno::with('moduloAsesoria')
                ->whereDate('fecha', now()->toDateString())
                ->where('estatus_turno_id', 2)
                ->latest('hora_llamado')
                ->first(),

            'turnosEnAtencion' => Turno::with('moduloAsesoria')
                ->whereDate('fecha', now()->toDateString())
                ->where('estatus_turno_id', 3)
                ->whereNotNull('modulo_asesoria_id')
                ->orderByDesc('hora_inicio_atencion')
                ->get(),
                                
            'proximosTurnos' => Turno::query()
                ->whereDate('fecha', now()->toDateString())
                ->where('estatus_turno_id', 1)
                ->orderBy('numero')
                ->limit(3)
                ->get(),


        ]);
    }
}