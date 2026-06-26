<?php

namespace App\Services\Reportes;

use App\Models\AsesoriaTramite;
use Illuminate\Support\Collection;
use App\Services\Reportes\ArbolMaestroService;

class EstadisticasService
{
    public function aplicarMovimientos(
        array $arbol,
        string $fechaInicio,
        string $fechaFin,
        ?int $asesorId = null,
        ?string $modalidad = null
    ): array {
        $movimientos = $this->obtenerMovimientos(
            fechaInicio: $fechaInicio,
            fechaFin: $fechaFin,
            asesorId: $asesorId,
            modalidad: $modalidad
        );

        foreach ($movimientos as $movimiento) {
            $tipoId = $movimiento->tipo_tramite_id;
            $clasificacionId = $movimiento->clasificacion_tramite_id;
            $tramiteId = $movimiento->tramite_id;
            $modalidad = $movimiento->modalidad;

            if (! isset($arbol[$tipoId]['clasificaciones'][$clasificacionId]['tramites'][$tramiteId])) {
                continue;
            }

            $cantidad = (int) $movimiento->total_cantidad;
            $importe = (float) $movimiento->total_importe;

            $tramite = &$arbol[$tipoId]['clasificaciones'][$clasificacionId]['tramites'][$tramiteId];

            $tramite['estadisticas'][$modalidad] += $cantidad;
            $tramite['estadisticas']['TOTAL'] += $cantidad;

            if ($tramite['catalogo']['requiere_declaracion']) {
                $tramite['estadisticas']['MONTO_VIRTUAL'] += $importe;
            }

            unset($tramite);
        }

        return $arbol;
    }

    private function obtenerMovimientos(
        string $fechaInicio,
        string $fechaFin,
        ?int $asesorId = null,
        ?string $modalidad = null
    ): Collection {
        $query = AsesoriaTramite::query()
            ->join('tramites', 'asesoria_tramites.tramite_id', '=', 'tramites.id')
            ->join('asesorias', 'asesoria_tramites.asesoria_id', '=', 'asesorias.id')
            ->whereBetween('asesorias.created_at', [
                $fechaInicio . ' 00:00:00',
                $fechaFin . ' 23:59:59',
            ]);

        if ($modalidad) {
            $query->where('asesorias.modalidad', $modalidad);
        }    

        if ($asesorId) {
            $query->where('asesorias.asesor_id', $asesorId);
        }

        return $query
            ->selectRaw('
                tramites.tipo_tramite_id,
                tramites.clasificacion_tramite_id,
                asesorias.modalidad,
                asesoria_tramites.tramite_id,
                SUM(asesoria_tramites.cantidad) as total_cantidad,
                SUM(COALESCE(asesoria_tramites.importe_declaracion, 0)) as total_importe
            ')
            ->groupBy(
                'tramites.tipo_tramite_id',
                'tramites.clasificacion_tramite_id',
                'asesorias.modalidad',
                'asesoria_tramites.tramite_id'
            )
            ->get();
    }

    public function calcularTotales(array $arbol): array
    {
        foreach ($arbol as $tipoId => &$tipo) {
            foreach ($tipo['clasificaciones'] as $clasificacionId => &$clasificacion) {
                foreach ($clasificacion['tramites'] as $tramite) {
                    foreach ($tramite['estadisticas'] as $clave => $valor) {
                        $clasificacion['estadisticas'][$clave] += $valor;
                    }
                }

                foreach ($clasificacion['estadisticas'] as $clave => $valor) {
                    $tipo['estadisticas'][$clave] += $valor;
                }
            }
        }

        unset($tipo, $clasificacion);

        return $arbol;
    }

    public function construirArbolEstadistico(
        string $fechaInicio,
        string $fechaFin,
        ?int $asesorId = null,
        ?string $modalidad = null
    ): array {
        $arbol = app(ArbolMaestroService::class)->construirArbol();

        $arbol = $this->aplicarMovimientos(
            arbol: $arbol,
            fechaInicio: $fechaInicio,
            fechaFin: $fechaFin,
            asesorId: $asesorId,
            modalidad: $modalidad
        );

        return $this->calcularTotales($arbol);
    }
}