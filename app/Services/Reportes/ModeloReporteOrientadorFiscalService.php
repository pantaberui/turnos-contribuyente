<?php

namespace App\Services\Reportes;

use App\Models\Asistencia;
use App\Models\User;
use Carbon\Carbon;

class ModeloReporteOrientadorFiscalService
{
    public function __construct(
        private ReporteComplementarioOrientadorService $complementarioService
    ) {
    }

    /**
     * Construye el modelo de datos del reporte individual
     * de un Orientador Fiscal.
     */
    public function construirModelo(
        string $fechaInicio,
        string $fechaFin,
        int $orientadorId
    ): array {
        $orientador = User::findOrFail($orientadorId);

        $asistencias = Asistencia::query()
            ->where('orientador_id', $orientadorId)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->whereNotNull('hora_fin');

        $complementario = $this->complementarioService
            ->valoresIniciales(
                orientadorId: $orientadorId,
                fechaInicio: $fechaInicio,
                fechaFin: $fechaFin
            );

        return [
            'periodo' => [
                'tipo' => $this->determinarTipoPeriodo(
                    $fechaInicio,
                    $fechaFin
                ),
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
            ],

            'consulta' => [
                'orientador_id' => $orientadorId,
                'orientador' => $orientador->nombre_completo,
            ],

            /*
             * AFLUENCIAS Y ORIENTACIONES FISCALES RIF
             *
             * Tipo de trámite 1:
             * TRÁMITE RÉGIMEN DE INCORPORACIÓN FISCAL
             */
            'rif' => [
                'personales' => (clone $asistencias)
                    ->where('tipo_tramite_id', 1)
                    ->count(),
            ],

            /*
             * TOTAL DE AFLUENCIAS EN GENERAL
             *
             * Incluye tanto:
             * - orientaciones resueltas directamente;
             * - orientaciones que requirieron turno.
             */
            'total_afluencias' => (clone $asistencias)->count(),

            /*
             * TOTAL DE TRÁMITES ESTATALES
             *
             * Tipo de trámite 2:
             * TRÁMITES ESTATALES
             */
            'tramites_estatales' => (clone $asistencias)
                ->where('tipo_tramite_id', 2)
                ->count(),

            /*
             * TOTAL DE REQUERIMIENTOS
             *
             * Tipo de trámite 3:
             * TRÁMITES FEDERALES
             */
            'requerimientos' => (clone $asistencias)
                ->where('tipo_tramite_id', 3)
                ->count(),

            /*
             * Por definición actual del reporte:
             * todavía no se determina qué trámites pertenecen
             * a "Otros trámites".
             */
            'otros_tramites' => 'Sin información',

            /*
             * Actividades adicionales capturadas para
             * este Orientador y periodo.
             */
            'actividades_adicionales' =>
                $complementario['actividades_adicionales'],

            'complementario_existe' =>
                $complementario['existe'],
        ];
    }

    /**
     * Determina el nombre del periodo a partir del rango.
     */
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