<?php

namespace App\Services\Reportes;

use App\Models\Asistencia;
use App\Models\User;
use Carbon\Carbon;

class ModeloReporteGeneralOrientadoresService
{
    public function __construct(
        private ReporteComplementarioOrientadorService $complementarioService
    ) {
    }

    public function construirModelo(
        string $fechaInicio,
        string $fechaFin,
        ?int $orientadorId = null
    ): array {
        $consultaOrientadores = User::role('Orientador Fiscal')
            ->orderBy('nombre')
            ->orderBy('apellido_paterno')
            ->orderBy('apellido_materno');

        if ($orientadorId) {
            $consultaOrientadores->where('users.id', $orientadorId);
        }

        $orientadores = $consultaOrientadores->get();

        $reportes = [];

        $totales = [
            'total_afluencias' => 0,
            'rif_personales' => 0,
            'tramites_estatales' => 0,
            'requerimientos' => 0,
        ];

        foreach ($orientadores as $orientador) {

            $asistencias = Asistencia::query()
                ->where('orientador_id', $orientador->id)
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->whereNotNull('hora_fin');

            $totalAfluencias = (clone $asistencias)->count();

            $rifPersonales = (clone $asistencias)
                ->where('tipo_tramite_id', 1)
                ->count();

            $tramitesEstatales = (clone $asistencias)
                ->where('tipo_tramite_id', 2)
                ->count();

            $requerimientos = (clone $asistencias)
                ->where('tipo_tramite_id', 3)
                ->count();

            $complementario = $this->complementarioService
                ->valoresIniciales(
                    orientadorId: $orientador->id,
                    fechaInicio: $fechaInicio,
                    fechaFin: $fechaFin
                );

            $reportes[] = [
                'orientador_id' => $orientador->id,

                'orientador' => $orientador->nombre_completo,

                'rif' => [
                    'personales' => $rifPersonales,
                ],

                'total_afluencias' => $totalAfluencias,

                'tramites_estatales' => $tramitesEstatales,

                'requerimientos' => $requerimientos,

                'otros_tramites' => 'Sin información',

                'actividades_adicionales' =>
                    $complementario['actividades_adicionales'],

                'complementario_existe' =>
                    $complementario['existe'],
            ];


            /*
            |--------------------------------------------------------------------------
            | Acumulados generales
            |--------------------------------------------------------------------------
            */

            $totales['total_afluencias'] += $totalAfluencias;

            $totales['rif_personales'] += $rifPersonales;

            $totales['tramites_estatales'] += $tramitesEstatales;

            $totales['requerimientos'] += $requerimientos;
        }

        return [
            'periodo' => [
                'tipo' => $this->determinarTipoPeriodo(
                    $fechaInicio,
                    $fechaFin
                ),

                'fecha_inicio' => $fechaInicio,

                'fecha_fin' => $fechaFin,
            ],

            'orientadores' => $reportes,

            'totales' => $totales,
        ];
    }


    private function determinarTipoPeriodo(
        string $fechaInicio,
        string $fechaFin
    ): string {
        $inicio = Carbon::parse($fechaInicio);

        $fin = Carbon::parse($fechaFin);

        $dias = $inicio->diffInDays($fin) + 1;

        return match ($dias) {

            7 => 'Semanal',

            14 => 'Quincenal',

            default => $dias >= 28 && $dias <= 31
                ? 'Mensual'
                : 'Personalizado',

        };
    }
}