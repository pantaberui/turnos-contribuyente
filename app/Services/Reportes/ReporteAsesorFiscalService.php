<?php

namespace App\Services\Reportes;

class ReporteAsesorFiscalService
{
    public function construir(array $modelo): array
    {
        $rif = $this->construirSeccionRif($modelo['arbol']);
        $estatales = $this->construirSeccionEstatales($modelo['arbol']);
        $totales = $this->construirTotales($modelo);

        return [
            'encabezado' => $this->construirEncabezado($modelo),

            'secciones' => [
                [
                    'titulo' => 'TRÁMITES RÉGIMEN DE INCORPORACIÓN FISCAL',
                    'contenido' => $rif,
                ],
                [
                    'titulo' => 'TRÁMITES ESTATALES',
                    'contenido' => $estatales,
                ],
            ],

            'totales' => $totales,
            'pie' => $this->construirPie(),

            // Compatibilidad temporal
            'periodo' => $modelo['periodo'],
            'rif' => $rif,
            'estatales' => $estatales,
            'resumenes' => $modelo['resumenes'],
        ];
    }

    private function construirSeccionRif(array $arbol): array
    {
        foreach ($arbol as $tipo) {
            if ($tipo['catalogo']['nombre'] === 'TRÁMITES RÉGIMEN DE INCORPORACIÓN FISCAL') {
                return $tipo;
            }
        }

        return [];
    }

    private function construirSeccionEstatales(array $arbol): array
    {
        foreach ($arbol as $tipo) {
            if ($tipo['catalogo']['nombre'] === 'TRÁMITES ESTATALES') {
                return $tipo;
            }
        }

        return [];
    }

    private function construirTotales(array $modelo): array
    {
        return [
            'total_asesorias' => $modelo['resumenes']['asesorias'],

            'total_declaraciones_tramites' => $modelo['resumenes']['declaraciones_tramites'],

            'total_general' => $modelo['resumenes']['general'],
        ];
    }

    private function construirEncabezado(array $modelo): array
    {
          return [
            'reporte' => [
                'nombre' => 'REPORTE MENSUAL DEL ASESOR FISCAL',
                'subtitulo' => 'IMPUESTOS ESTATALES Y RÉGIMEN DE INCORPORACIÓN FISCAL (RIIF)',
            ],
            'consulta' => [
                'asesor' => $modelo['consulta']['asesor'] ?? 'TODOS',
                'modalidad' => $modelo['consulta']['modalidad'] ?? 'TODAS',
            ],
            'periodo' => $modelo['periodo'],
            'modulo' => 'TEPIC',
        ];
    }

    private function construirPie(): array
    {
        return [
            'firma_label' => 'FIRMA',
            'nombre_firma' => '',
            'actividades_label' => 'ACTIVIDADES REALIZADAS EN EL MES (FUNCIONES ADICIONALES)',
        ];
    }
}