<?php

namespace App\Services\Reportes;

use App\Models\ReporteDatoComplementarioOrientador;
use Illuminate\Support\Carbon;

class ReporteComplementarioOrientadorService
{
    /**
     * Obtiene la información complementaria de un Orientador
     * para un periodo determinado.
     */
    public function obtener(
        int $orientadorId,
        Carbon|string $fechaInicio,
        Carbon|string $fechaFin
    ): ?ReporteDatoComplementarioOrientador {
        return ReporteDatoComplementarioOrientador::query()
            ->where('orientador_id', $orientadorId)
            ->whereDate(
                'fecha_inicio',
                Carbon::parse($fechaInicio)->toDateString()
            )
            ->whereDate(
                'fecha_fin',
                Carbon::parse($fechaFin)->toDateString()
            )
            ->first();
    }

    /**
     * Determina si ya existe información complementaria.
     */
    public function existe(
        int $orientadorId,
        Carbon|string $fechaInicio,
        Carbon|string $fechaFin
    ): bool {
        return ReporteDatoComplementarioOrientador::query()
            ->where('orientador_id', $orientadorId)
            ->whereDate(
                'fecha_inicio',
                Carbon::parse($fechaInicio)->toDateString()
            )
            ->whereDate(
                'fecha_fin',
                Carbon::parse($fechaFin)->toDateString()
            )
            ->exists();
    }

    /**
     * Guarda o actualiza las actividades adicionales.
     */
    public function guardar(
        int $orientadorId,
        Carbon|string $fechaInicio,
        Carbon|string $fechaFin,
        array $datos,
        ?int $capturadoPor = null
    ): ReporteDatoComplementarioOrientador {
        $inicio = Carbon::parse($fechaInicio)->toDateString();
        $fin = Carbon::parse($fechaFin)->toDateString();

        return ReporteDatoComplementarioOrientador::query()->updateOrCreate(
            [
                'orientador_id' => $orientadorId,
                'fecha_inicio' => $inicio,
                'fecha_fin' => $fin,
            ],
            [
                'tipo_periodo' => $datos['tipo_periodo'] ?? 'Mensual',
                'actividades_adicionales' =>
                    $datos['actividades_adicionales'] ?? null,
                'capturado_por' => $capturadoPor,
            ]
        );
    }

    /**
     * Devuelve los valores iniciales para mostrar
     * en el formulario de actividades.
     */
    public function valoresIniciales(
        int $orientadorId,
        Carbon|string $fechaInicio,
        Carbon|string $fechaFin
    ): array {
        $registro = $this->obtener(
            $orientadorId,
            $fechaInicio,
            $fechaFin
        );

        return [
            'actividades_adicionales' =>
                $registro?->actividades_adicionales ?? '',

            'existe' => $registro !== null,
        ];
    }
}