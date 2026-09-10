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
            'tramites_estatales_resumen' => $this->construirTramitesEstatalesResumen($arbol),

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

    private function construirTramitesEstatalesResumen(array $arbol): array
    {
        $grupos = [
            'nominas' => $this->estructuraResumenEstatal(),
            'hospedaje' => $this->estructuraResumenEstatal(),
            'cedulares' => $this->estructuraResumenEstatal(),
            'bebidas_alcoholicas' => $this->estructuraResumenEstatal(),
            'juegos_apuestas_rifas' => $this->estructuraResumenEstatal(),
            'otros' => $this->estructuraResumenEstatal(),
        ];

        /*
        * Tipo 2 = Impuestos Estatales.
        *
        * Solo se consideran las clasificaciones 1 a 6.
        * La 7 = Refrendo Vehicular no aplica.
        * La 8 = Solventación se procesa en su sección correspondiente.
        */
        $tipoEstatal = $arbol[2] ?? null;

        if (!$tipoEstatal) {
            return [
                'grupos' => $grupos,
                'totales' => $this->estructuraResumenEstatal(),
            ];
        }

        foreach ($tipoEstatal['clasificaciones'] as $clasificacion) {

            $numeroClasificacion = (int) ($clasificacion['catalogo']['numero'] ?? 0);

            if ($numeroClasificacion < 1 || $numeroClasificacion > 6) {
                continue;
            }

            foreach ($clasificacion['tramites'] as $tramite) {

                $nombre = mb_strtoupper(
                    trim($tramite['catalogo']['nombre'] ?? ''),
                    'UTF-8'
                );

                $categoria = $tramite['catalogo']['categoria'] ?? null;

                if (!in_array($categoria, [
                    'ASESORIA',
                    'DECLARACION_TRAMITE',
                ], true)) {
                    continue;
                }

                $grupo = $this->clasificarTramiteEstatal($nombre);

                $destino = match ($categoria) {
                    'ASESORIA' => 'asesorias',
                    'DECLARACION_TRAMITE' => 'declaraciones_tramites',
                    default => null,
                };

                if ($destino === null) {
                    continue;
                }

                $estadisticas = $tramite['estadisticas'] ?? [];

                $grupos[$grupo][$destino]['PRESENCIAL']
                    += (int) ($estadisticas['PRESENCIAL'] ?? 0);

                $grupos[$grupo][$destino]['TELEFONICA']
                    += (int) ($estadisticas['TELEFONICA'] ?? 0);

                $grupos[$grupo][$destino]['CORREO']
                    += (int) ($estadisticas['CORREO'] ?? 0);

                $grupos[$grupo][$destino]['TOTAL']
                    += (int) ($estadisticas['TOTAL'] ?? 0);

                $grupos[$grupo][$destino]['MONTO_VIRTUAL']
                    += (float) ($estadisticas['MONTO_VIRTUAL'] ?? 0);
            }
        }

        $totales = [
            'asesorias' => [
                'PRESENCIAL' => 0,
                'TELEFONICA' => 0,
                'CORREO' => 0,
                'TOTAL' => 0,
                'MONTO_VIRTUAL' => 0,
            ],

            'declaraciones_tramites' => [
                'PRESENCIAL' => 0,
                'TELEFONICA' => 0,
                'CORREO' => 0,
                'TOTAL' => 0,
                'MONTO_VIRTUAL' => 0,
            ],
        ];

        foreach ($grupos as $grupo) {

            foreach (['asesorias', 'declaraciones_tramites'] as $categoria) {

                $totales[$categoria]['PRESENCIAL']
                    += $grupo[$categoria]['PRESENCIAL'];

                $totales[$categoria]['TELEFONICA']
                    += $grupo[$categoria]['TELEFONICA'];

                $totales[$categoria]['CORREO']
                    += $grupo[$categoria]['CORREO'];

                $totales[$categoria]['TOTAL']
                    += $grupo[$categoria]['TOTAL'];

                $totales[$categoria]['MONTO_VIRTUAL']
                    += $grupo[$categoria]['MONTO_VIRTUAL'];
            }
        }

        return [
            'grupos' => $grupos,
            'totales' => $totales,
        ];
    }

    private function estructuraResumenEstatal(): array
    {
        return [
            'asesorias' => [
                'PRESENCIAL' => 0,
                'TELEFONICA' => 0,
                'CORREO' => 0,
                'TOTAL' => 0,
                'MONTO_VIRTUAL' => 0,
            ],

            'declaraciones_tramites' => [
                'PRESENCIAL' => 0,
                'TELEFONICA' => 0,
                'CORREO' => 0,
                'TOTAL' => 0,
                'MONTO_VIRTUAL' => 0,
            ],
        ];
    }

    private function clasificarTramiteEstatal(string $nombre): string
    {
        if (
            str_contains($nombre, 'NÓMINA') ||
            str_contains($nombre, 'NOMINA')
        ) {
            return 'nominas';
        }

        if (str_contains($nombre, 'HOSPEDAJE')) {
            return 'hospedaje';
        }

        if (str_contains($nombre, 'CEDULAR')) {
            return 'cedulares';
        }

        if (
            str_contains($nombre, 'BEBIDA CON CONTENIDO ALCOHÓLICO') ||
            str_contains($nombre, 'BEBIDA CON CONTENIDO ALCOHOLICO')
        ) {
            return 'bebidas_alcoholicas';
        }

        if (
            str_contains($nombre, 'JUEGOS Y APUESTAS') ||
            str_contains($nombre, 'RIFAS') ||
            str_contains($nombre, 'LOTERIAS') ||
            str_contains($nombre, 'LOTERÍAS') ||
            str_contains($nombre, 'SORTEOS')
        ) {
            return 'juegos_apuestas_rifas';
        }

        return 'otros';
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
