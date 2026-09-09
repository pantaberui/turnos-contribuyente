<?php

namespace App\Services\Reportes;

use App\DataTransferObjects\Reportes\DocumentoReporte;

abstract class BaseDocumentoReporteService
{
    protected string $nombreReporte;

    protected string $subtituloReporte = 'IMPUESTOS ESTATALES Y RÉGIMEN DE INCORPORACIÓN FISCAL (RIIF)';

    public function construir(array $modelo): DocumentoReporte
    {
        return new DocumentoReporte(
            encabezado: $this->construirEncabezado($modelo),
            totales: $this->construirTotales($modelo),
            secciones: $this->construirSecciones($modelo),
            pie: $this->construirPie($modelo),
            complementario: $modelo['complementario'] ?? [],
            contribuyentes: $modelo['contribuyentes'] ?? [],
            solventaciones: $modelo['solventaciones'] ?? [],
            resumenes: $modelo['resumenes'] ?? [],
        );
    }

    protected function construirEncabezado(array $modelo): array
    {
        return [
            'reporte' => [
                'nombre' => $this->nombreReporte,
                'subtitulo' => $this->subtituloReporte,
            ],
            'periodo' => $modelo['periodo'],
            'modulo' => 'TEPIC',
            'consulta' => [
                'asesor' => $modelo['consulta']['asesor'] ?? 'TODOS',
                'modalidad' => $modelo['consulta']['modalidad'] ?? 'TODAS',
            ],
        ];
    }

    protected function construirTotales(array $modelo): array
    {
        return [
            'total_asesorias' => $modelo['resumenes']['asesorias'],
            'total_declaraciones_tramites' => $modelo['resumenes']['declaraciones_tramites'],
            'total_general' => $modelo['resumenes']['general'],
        ];
    }

    protected function construirSecciones(array $modelo): array
    {
        $secciones = [];

        foreach ($modelo['arbol'] as $tipo) {
            $secciones[] = [
                'titulo' => $tipo['catalogo']['nombre'],
                'contenido' => $tipo,
            ];
        }

        return $secciones;
    }

    protected function construirPie(array $modelo = []): array
    {
        return [
            'firma_label' => 'FIRMA',
            'nombre_firma' => $modelo['consulta']['asesor'] ?? '',
            'actividades_label' => 'ACTIVIDADES REALIZADAS EN EL MES',
        ];
    }
}