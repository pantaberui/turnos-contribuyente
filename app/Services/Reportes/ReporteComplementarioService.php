<?php

namespace App\Services\Reportes;

use App\Models\ReporteDatoComplementario;
use Illuminate\Support\Carbon;

class ReporteComplementarioService
{
    /**
     * Obtiene la información complementaria de un asesor y periodo.
     */
    public function obtener(
        int $asesorId,
        Carbon|string $fechaInicio,
        Carbon|string $fechaFin
    ): ?ReporteDatoComplementario {
        return ReporteDatoComplementario::query()
            ->where('asesor_id', $asesorId)
            ->whereDate('fecha_inicio', Carbon::parse($fechaInicio)->toDateString())
            ->whereDate('fecha_fin', Carbon::parse($fechaFin)->toDateString())
            ->first();
    }

    /**
     * Determina si ya existe información complementaria.
     */
    public function existe(
        int $asesorId,
        Carbon|string $fechaInicio,
        Carbon|string $fechaFin
    ): bool {
        return ReporteDatoComplementario::query()
            ->where('asesor_id', $asesorId)
            ->whereDate('fecha_inicio', Carbon::parse($fechaInicio)->toDateString())
            ->whereDate('fecha_fin', Carbon::parse($fechaFin)->toDateString())
            ->exists();
    }

    /**
     * Guarda o actualiza la información complementaria.
     */
    public function guardar(
        int $asesorId,
        Carbon|string $fechaInicio,
        Carbon|string $fechaFin,
        array $datos,
        ?int $capturadoPor = null
    ): ReporteDatoComplementario {
        $inicio = Carbon::parse($fechaInicio)->toDateString();
        $fin = Carbon::parse($fechaFin)->toDateString();

        return ReporteDatoComplementario::query()->updateOrCreate(
            [
                'asesor_id' => $asesorId,
                'fecha_inicio' => $inicio,
                'fecha_fin' => $fin,
            ],
            [
                'tipo_periodo' => $datos['tipo_periodo'] ?? 'Mensual',
                'talleres_rif' => $datos['talleres_rif'] ?? 0,
                'talleres_estatales' => $datos['talleres_estatales'] ?? 0,
                'proyectos_realizados' => $datos['proyectos_realizados'] ?? 0,
                'actividades_adicionales' => $datos['actividades_adicionales'] ?? null,
                'capturado_por' => $capturadoPor,
            ]
        );
    }

    /**
     * Devuelve valores predeterminados cuando todavía no existe captura.
     */
    public function valoresIniciales(
        int $asesorId,
        Carbon|string $fechaInicio,
        Carbon|string $fechaFin
    ): array {
        $registro = $this->obtener(
            $asesorId,
            $fechaInicio,
            $fechaFin
        );

        return [
            'talleres_rif' => $registro?->talleres_rif ?? 0,
            'talleres_estatales' => $registro?->talleres_estatales ?? 0,
            'proyectos_realizados' => $registro?->proyectos_realizados ?? 0,
            'actividades_adicionales' => $registro?->actividades_adicionales ?? '',
            'existe' => $registro !== null,
        ];
    }
}