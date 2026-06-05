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


        $asistenciasHoy = Asistencia::whereDate('fecha', $hoy)->count();

        $orientacionesSinTurno = Asistencia::whereDate('fecha', $hoy)
            ->where('requiere_turno', false)
            ->count();

        $orientacionesConTurno = Asistencia::whereDate('fecha', $hoy)
            ->where('requiere_turno', true)
            ->count();
        
        $promedioOrientacion = round(
            Asistencia::whereDate('fecha', $hoy)
                ->avg('tiempo_orientacion_segundos') ?? 0
        );

        $promedioAtencion = round(
            Turno::whereDate('fecha', $hoy)
                ->where('estatus_turno_id', 3)
                ->avg('tiempo_atencion_segundos') ?? 0
        );

        $topAsesores = Turno::query()
        ->selectRaw('asesor_id, COUNT(*) as total')
        ->whereDate('fecha', $hoy)
        ->where('estatus_turno_id', 3)
        ->groupBy('asesor_id')
        ->with('asesor')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

        $topOrientadores = Asistencia::query()
        ->selectRaw('orientador_id, COUNT(*) as total')
        ->whereDate('fecha', $hoy)
        ->whereNotNull('orientador_id')
        ->groupBy('orientador_id')
        ->with('orientador')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

        $turnosPendientes = Turno::whereDate('fecha', $hoy)
        ->where('estatus_turno_id', 1)
        ->count();

        $promedioOrientacion = round(
            Asistencia::whereDate('fecha', $hoy)
                ->avg('tiempo_orientacion_segundos') ?? 0
        );

        return view('livewire.dashboard-index', [
            'asistenciasHoy' => Asistencia::whereDate('fecha', $hoy)->count(),

            'orientacionesSinTurno' => Asistencia::whereDate('fecha', $hoy)
                ->where('requiere_turno', false)
                ->whereNotNull('hora_fin')
                ->count(),

            'orientacionesConTurno' => $orientacionesConTurno,

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

            'promedioAtencion' => $promedioAtencion,

            'promedioOrientacion' => $promedioOrientacion,

            'topAsesores' => $topAsesores,

            'topOrientadores' => $topOrientadores,

            'turnosPendientes' => $turnosPendientes,
        ]);
    }
}