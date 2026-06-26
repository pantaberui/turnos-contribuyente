<?php

namespace App\Services\Reportes;

class ReporteAsesorFiscalService
{
    public function construir(array $modelo): array
    {
        return [
            'periodo' => $modelo['periodo'],

            'rif' => $this->construirSeccionRif($modelo['arbol']),

            'estatales' => $this->construirSeccionEstatales($modelo['arbol']),

            'totales' => $this->construirTotales($modelo),

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
}