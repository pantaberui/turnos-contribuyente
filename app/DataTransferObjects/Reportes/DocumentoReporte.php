<?php

namespace App\DataTransferObjects\Reportes;

class DocumentoReporte
{
    public array $encabezado = [];
    public array $totales = [];
    public array $secciones = [];
    public array $pie = [];
    public array $complementario = [];
    public array $contribuyentes = [];
    public array $solventaciones = [];
    public array $resumenes = [];
    public array $tramites_estatales_resumen = [];

    public function __construct(
        array $encabezado = [],
        array $totales = [],
        array $secciones = [],
        array $pie = [],
        array $complementario = [],
        array $contribuyentes = [],
        array $solventaciones = [],
        array $resumenes = [],
        array $tramites_estatales_resumen = [],
    ) {
        $this->encabezado = $encabezado;
        $this->totales = $totales;
        $this->secciones = $secciones;
        $this->pie = $pie;
        $this->complementario = $complementario;
        $this->contribuyentes = $contribuyentes;
        $this->solventaciones = $solventaciones;
        $this->resumenes = $resumenes;
        $this->tramites_estatales_resumen = $tramites_estatales_resumen;
    }
}