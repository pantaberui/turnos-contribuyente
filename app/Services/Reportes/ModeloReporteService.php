<?php

namespace App\Services\Reportes;

class ModeloReporteService
{
    public function construirModelo(
        string $fechaInicio,
        string $fechaFin,
        string $tipoPeriodo = 'Mensual',
        ?int $asesorId = null,
        ?string $modalidad = null
    ): array
    {
        $arbol = app(EstadisticasService::class)
            ->construirArbolEstadistico(
                fechaInicio: $fechaInicio,
                fechaFin: $fechaFin,
                asesorId: $asesorId,
                modalidad: $modalidad
            );

        return [
            'periodo' => [
                'tipo' => $tipoPeriodo,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
            ],
            'consulta' => [
                'asesor_id' => $asesorId,
                'modalidad' => $modalidad ?: 'TODAS',
            ],

            'arbol' => $arbol,

            'resumenes' => $this->construirResumenes($arbol),
        ];
    }

    private function construirResumenes(array $arbol): array
    {
        $resumenes = [
            'asesorias' => $this->estructuraResumen(),
            'declaraciones_tramites' => $this->estructuraResumen(),
            'general' => $this->estructuraResumen(),
        ];

        foreach ($arbol as $tipo) {
            foreach ($tipo['clasificaciones'] as $clasificacion) {
                foreach ($clasificacion['tramites'] as $tramite) {

                    $categoria = $tramite['catalogo']['categoria'];
                    $estadisticas = $tramite['estadisticas'];

                    if ($categoria === 'ASESORIA') {
                        $this->sumarResumen(
                            $resumenes['asesorias'],
                            $estadisticas
                        );
                    }

                    if ($categoria === 'DECLARACION_TRAMITE') {
                        $this->sumarResumen(
                            $resumenes['declaraciones_tramites'],
                            $estadisticas
                        );
                    }

                    $this->sumarResumen(
                        $resumenes['general'],
                        $estadisticas
                    );
                }
            }
        }

        return $resumenes;
    }

    private function estructuraResumen(): array
    {
        return [
            'PRESENCIAL' => 0,
            'TELEFONICA' => 0,
            'CORREO' => 0,
            'TOTAL' => 0,
            'MONTO_VIRTUAL' => 0,
        ];
    }

    private function sumarResumen(array &$resumen, array $estadisticas): void
    {
        $resumen['PRESENCIAL'] += $estadisticas['PRESENCIAL'];
        $resumen['TELEFONICA'] += $estadisticas['TELEFONICA'];
        $resumen['CORREO'] += $estadisticas['CORREO'];
        $resumen['TOTAL'] += $estadisticas['TOTAL'];
        $resumen['MONTO_VIRTUAL'] += $estadisticas['MONTO_VIRTUAL'];
    }


}