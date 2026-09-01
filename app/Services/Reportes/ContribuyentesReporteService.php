<?php

namespace App\Services\Reportes;

use App\Models\AsesoriaTramite;
use Illuminate\Support\Facades\DB;

class ContribuyentesReporteService
{
    public function obtenerTotales(
        string $fechaInicio,
        string $fechaFin,
        ?int $asesorId = null,
        ?string $modalidad = null
    ): array {
        $query = AsesoriaTramite::query()
            ->join(
                'asesorias',
                'asesoria_tramites.asesoria_id',
                '=',
                'asesorias.id'
            )
            ->join(
                'tramites',
                'asesoria_tramites.tramite_id',
                '=',
                'tramites.id'
            )
            ->whereBetween('asesorias.created_at', [
                $fechaInicio . ' 00:00:00',
                $fechaFin . ' 23:59:59',
            ])
            ->whereNotNull('asesoria_tramites.contribuyente_id')
            ->whereIn('tramites.tipo_tramite_id', [1, 2]);

        if ($asesorId !== null) {
            $query->where('asesorias.asesor_id', $asesorId);
        }

        if ($modalidad !== null) {
            $query->where('asesorias.modalidad', $modalidad);
        }

        $resultados = $query
            ->select(
                'tramites.tipo_tramite_id',
                DB::raw('COUNT(DISTINCT asesoria_tramites.contribuyente_id) AS total')
            )
            ->groupBy('tramites.tipo_tramite_id')
            ->pluck('total', 'tipo_tramite_id');

        return [
            'rif' => (int) ($resultados[1] ?? 0),
            'estatales' => (int) ($resultados[2] ?? 0),
        ];
    }
}