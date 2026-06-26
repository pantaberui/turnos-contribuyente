<?php

namespace App\Services;

use App\Models\AsesoriaTramite;
use Illuminate\Support\Collection;

class ReporteService
{
    private const MODALIDADES = [
        'PRESENCIAL',
        'TELEFONICA',
        'CORREO',
    ];


    public function obtenerDatosBase(
        string $fechaInicio,
        string $fechaFin,
        ?string $modalidad = null,
        ?int $asesorId = null
    ): Collection {
        $query = AsesoriaTramite::query()
            ->join('tramites', 'asesoria_tramites.tramite_id', '=', 'tramites.id')
            ->join('asesorias', 'asesoria_tramites.asesoria_id', '=', 'asesorias.id')
            ->join('tipo_tramites', 'tramites.tipo_tramite_id', '=', 'tipo_tramites.id')
            ->join('clasificacion_tramites', 'tramites.clasificacion_tramite_id', '=', 'clasificacion_tramites.id')
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
                asesorias.modalidad,
                tipo_tramites.nombre as tipo,
                clasificacion_tramites.nombre as clasificacion,
                tramites.nombre as tramite,
                tramites.categoria,
                tramites.requiere_declaracion,
                SUM(asesoria_tramites.cantidad) as total_cantidad,
                SUM(COALESCE(asesoria_tramites.importe_declaracion, 0)) as total_importe
            ')
            ->groupBy(
                'asesorias.modalidad',
                'tipo_tramites.nombre',
                'clasificacion_tramites.nombre',
                'tramites.nombre',
                'tramites.categoria',
                'tramites.requiere_declaracion'
            )
            ->orderBy('tipo_tramites.nombre')
            ->orderBy('clasificacion_tramites.nombre')
            ->orderBy('tramites.nombre')
            ->get();
    }

    private function estructuraModalidades(): array
    {
        return [
            'PRESENCIAL' => 0,
            'TELEFONICA' => 0,
            'CORREO' => 0,
            'TOTAL' => 0,
            'MONTO_VIRTUAL' => 0,
        ];
    }

    public function obtenerResumenPorModalidad(
        string $fechaInicio,
        string $fechaFin,
        ?int $asesorId = null
    ): array {
        $datos = $this->obtenerDatosBase(
            fechaInicio: $fechaInicio,
            fechaFin: $fechaFin,
            asesorId: $asesorId
        );

        $resumen = $this->estructuraModalidades();

        foreach ($datos as $fila) {
            $modalidad = $fila->modalidad;

            if (! isset($resumen[$modalidad])) {
                continue;
            }

            $resumen[$modalidad] += (int) $fila->total_cantidad;
            $resumen['TOTAL'] += (int) $fila->total_cantidad;
            if ((bool) $fila->requiere_declaracion) {
                $resumen['MONTO_VIRTUAL'] += (float) $fila->total_importe;
            }
        }

        return $resumen;
    }

    public function obtenerEstructuraPorTipo(
        string $fechaInicio,
        string $fechaFin,
        ?int $asesorId = null
    ): array {
        $datos = $this->obtenerDatosBase(
            fechaInicio: $fechaInicio,
            fechaFin: $fechaFin,
            asesorId: $asesorId
        );

        $reporte = [];

        foreach ($datos as $fila) {
            $tipo = $fila->tipo;
            $clasificacion = $fila->clasificacion;
            $tramite = $fila->tramite;

            if (! isset($reporte[$tipo])) {
                $reporte[$tipo] = [];
            }

            if (! isset($reporte[$tipo][$clasificacion])) {
                $reporte[$tipo][$clasificacion] = [];
            }

            if (! isset($reporte[$tipo][$clasificacion][$tramite])) {
                $reporte[$tipo][$clasificacion][$tramite] = [
                    'categoria' => $fila->categoria,
                    'requiere_declaracion' => (bool) $fila->requiere_declaracion,
                    'modalidades' => $this->estructuraModalidades(),
                ];
            }

            $modalidad = $fila->modalidad;

            if (isset($reporte[$tipo][$clasificacion][$tramite]['modalidades'][$modalidad])) {
                $reporte[$tipo][$clasificacion][$tramite]['modalidades'][$modalidad] += (int) $fila->total_cantidad;
                $reporte[$tipo][$clasificacion][$tramite]['modalidades']['TOTAL'] += (int) $fila->total_cantidad;
                if ((bool) $fila->requiere_declaracion) {
                    $reporte[$tipo][$clasificacion][$tramite]['modalidades']['MONTO_VIRTUAL'] += (float) $fila->total_importe;
                }
            }
        }

        return $reporte;
    }

    public function obtenerResumenPorCategoria(
        string $fechaInicio,
        string $fechaFin,
        ?int $asesorId = null
    ): array {
        $datos = $this->obtenerDatosBase(
            fechaInicio: $fechaInicio,
            fechaFin: $fechaFin,
            asesorId: $asesorId
        );

        $resumen = [
            'ASESORIA' => $this->estructuraModalidades(),
            'DECLARACION_TRAMITE' => $this->estructuraModalidades(),
        ];

        foreach ($datos as $fila) {
            $categoria = $fila->categoria;
            $modalidad = $fila->modalidad;

            if (! isset($resumen[$categoria])) {
                continue;
            }

            if (! isset($resumen[$categoria][$modalidad])) {
                continue;
            }

            $resumen[$categoria][$modalidad] += (int) $fila->total_cantidad;
            $resumen[$categoria]['TOTAL'] += (int) $fila->total_cantidad;

            if ((bool) $fila->requiere_declaracion) {
                $resumen[$categoria]['MONTO_VIRTUAL'] += (float) $fila->total_importe;
            }
        }

        return $resumen;
    }

    public function obtenerResumenPorTipo(
        string $fechaInicio,
        string $fechaFin,
        ?int $asesorId = null
    ): array {
        $estructura = $this->obtenerEstructuraPorTipo(
            fechaInicio: $fechaInicio,
            fechaFin: $fechaFin,
            asesorId: $asesorId
        );

        $resumen = [];

        foreach ($estructura as $tipo => $clasificaciones) {
            $resumen[$tipo] = $this->estructuraModalidades();

            foreach ($clasificaciones as $tramites) {
                foreach ($tramites as $datosTramite) {
                    foreach (['PRESENCIAL', 'TELEFONICA', 'CORREO'] as $modalidad) {
                        $resumen[$tipo][$modalidad] += $datosTramite['modalidades'][$modalidad];
                    }

                    $resumen[$tipo]['TOTAL'] += $datosTramite['modalidades']['TOTAL'];
                    $resumen[$tipo]['MONTO_VIRTUAL'] += $datosTramite['modalidades']['MONTO_VIRTUAL'];
                }
            }
        }

        return $resumen;
    }


    public function obtenerResumenPorTipoYCategoria(
        string $fechaInicio,
        string $fechaFin,
        ?int $asesorId = null
    ): array {
        $datos = $this->obtenerDatosBase(
            fechaInicio: $fechaInicio,
            fechaFin: $fechaFin,
            asesorId: $asesorId
        );

        $resumen = [];

        foreach ($datos as $fila) {
            $tipo = $fila->tipo;
            $categoria = $fila->categoria;
            $modalidad = $fila->modalidad;

            if (! isset($resumen[$tipo])) {
                $resumen[$tipo] = [
                    'ASESORIA' => $this->estructuraModalidades(),
                    'DECLARACION_TRAMITE' => $this->estructuraModalidades(),
                ];
            }

            if (! isset($resumen[$tipo][$categoria])) {
                continue;
            }

            $resumen[$tipo][$categoria][$modalidad] += (int) $fila->total_cantidad;
            $resumen[$tipo][$categoria]['TOTAL'] += (int) $fila->total_cantidad;

            if ((bool) $fila->requiere_declaracion) {
                $resumen[$tipo][$categoria]['MONTO_VIRTUAL'] += (float) $fila->total_importe;
            }
        }

        return $resumen;
    }

    public function construirModelo(
        string $fechaInicio,
        string $fechaFin,
        string $tipoPeriodo = 'Mensual',
        ?int $asesorId = null,
        ?string $modalidad = null
    ): array {
        return [
            'periodo' => [
                'tipo' => $tipoPeriodo,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
            ],

            'resumen_modalidad' => $this->obtenerResumenPorModalidad(
                fechaInicio: $fechaInicio,
                fechaFin: $fechaFin,
                asesorId: $asesorId
            ),

            'resumen_categoria' => $this->obtenerResumenPorCategoria(
                fechaInicio: $fechaInicio,
                fechaFin: $fechaFin,
                asesorId: $asesorId
            ),

            'resumen_tipo' => $this->obtenerResumenPorTipo(
                fechaInicio: $fechaInicio,
                fechaFin: $fechaFin,
                asesorId: $asesorId
            ),

            'resumen_tipo_categoria' => $this->obtenerResumenPorTipoYCategoria(
                fechaInicio: $fechaInicio,
                fechaFin: $fechaFin,
                asesorId: $asesorId
            ),

            'estructura_tipo' => $this->obtenerEstructuraPorTipo(
                fechaInicio: $fechaInicio,
                fechaFin: $fechaFin,
                asesorId: $asesorId
            ),
        ];
    }

}