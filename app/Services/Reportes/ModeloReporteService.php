<?php

namespace App\Services\Reportes;

class ModeloReporteService
{
   private ReporteComplementarioService $reporteComplementarioService;
   private ContribuyentesReporteService $contribuyentesReporteService;

    public function __construct(
        ReporteComplementarioService $reporteComplementarioService,
        ContribuyentesReporteService $contribuyentesReporteService
    ) {
        $this->reporteComplementarioService = $reporteComplementarioService;
        $this->contribuyentesReporteService = $contribuyentesReporteService;
    }

    public function construirModelo(
        string $fechaInicio,
        string $fechaFin,
        string $tipoPeriodo = 'Mensual',
        ?int $asesorId = null,
        ?string $modalidad = null
    ): array {
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

            'contribuyentes' => $this->contribuyentesReporteService->obtenerTotales(
                fechaInicio: $fechaInicio,
                fechaFin: $fechaFin,
                asesorId: $asesorId,
                modalidad: $modalidad
            ),

            'complementario' => $this->construirComplementario(
                asesorId: $asesorId,
                fechaInicio: $fechaInicio,
                fechaFin: $fechaFin
            ),

            'solventaciones' => $this->construirSolventaciones($arbol),
        ];
    }

    private function construirSolventaciones(array $arbol): array
    {
        $estatales = $arbol[2]['clasificaciones'][10]['estadisticas']['TOTAL'] ?? 0;

        $federales = $arbol[3]['clasificaciones'][13]['estadisticas']['TOTAL'] ?? 0;

        $exhortos = $arbol[2]['clasificaciones'][11]['estadisticas']['TOTAL'] ?? 0;

        return [
            'estatales' => (int) $estatales,
            'federales' => (int) $federales,
            'exhortos' => (int) $exhortos,
            'total' => (int) ($estatales + $federales + $exhortos),
        ];
    }


    private function construirComplementario(
        ?int $asesorId,
        string $fechaInicio,
        string $fechaFin
    ): array {
        /*
         * La captura complementaria actualmente pertenece a un asesor.
         * Cuando el reporte es general, asesor_id es null y no corresponde
         * buscar un registro individual.
         */
        if ($asesorId === null) {
            return [
                'talleres_rif' => 0,
                'talleres_estatales' => 0,
                'proyectos_realizados' => 0,
                'actividades_adicionales' => '',
                'existe' => false,
                'aplica' => false,
            ];
        }

        return [
            ...$this->reporteComplementarioService->valoresIniciales(
                asesorId: $asesorId,
                fechaInicio: $fechaInicio,
                fechaFin: $fechaFin
            ),
            'aplica' => true,
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

    private function sumarResumen(
        array &$resumen,
        array $estadisticas
    ): void {
        $resumen['PRESENCIAL'] += $estadisticas['PRESENCIAL'];
        $resumen['TELEFONICA'] += $estadisticas['TELEFONICA'];
        $resumen['CORREO'] += $estadisticas['CORREO'];
        $resumen['TOTAL'] += $estadisticas['TOTAL'];
        $resumen['MONTO_VIRTUAL'] += $estadisticas['MONTO_VIRTUAL'];
    }
}
