<?php

namespace App\DataTransferObjects\Reportes;

class DocumentoReporte
{
    public array $encabezado;
    public array $totales;
    public array $secciones;
    public array $pie;

    public function __construct(
        array $encabezado = [],
        array $totales = [],
        array $secciones = [],
        array $pie = [],
    ) {
        $this->encabezado = $encabezado;
        $this->totales = $totales;
        $this->secciones = $secciones;
        $this->pie = $pie;
    }
}