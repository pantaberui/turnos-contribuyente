<?php

namespace App\DataTransferObjects\Reportes;

class DocumentoReporte
{
    public array $encabezado = [];
    public array $totales = [];
    public array $secciones = [];
    public array $pie = [];
    public array $complementario = [];

    public function __construct(
        array $encabezado = [],
        array $totales = [],
        array $secciones = [],
        array $pie = [],
        array $complementario = [],
    ) {
        $this->encabezado = $encabezado;
        $this->totales = $totales;
        $this->secciones = $secciones;
        $this->pie = $pie;
        $this->complementario = $complementario;
    }
}