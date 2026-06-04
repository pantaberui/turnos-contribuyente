<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Asistencia;
use App\Models\Turno;

class DashboardIndex extends Component
{
    public function render()
    {
        $hoy = now()->toDateString();

        return view('livewire.dashboard-index', [
            'asistenciasHoy' => Asistencia::whereDate('fecha', $hoy)->count(),

            'orientacionesSinTurno' => Asistencia::whereDate('fecha', $hoy)
                ->where('requiere_turno', false)
                ->whereNotNull('hora_fin')
                ->count(),

            'turnosGenerados' => Turno::whereDate('fecha', $hoy)->count(),

            'turnosAtendidos' => Turno::whereDate('fecha', $hoy)
                ->where('estatus_turno_id', 3)
                ->count(),

            'turnosNoPresentados' => Turno::whereDate('fecha', $hoy)
                ->where('estatus_turno_id', 6)
                ->count(),

            'turnosEnAtencion' => Turno::whereDate('fecha', $hoy)
                ->where('estatus_turno_id', 2)
                ->count(),
        ]);
    }
}