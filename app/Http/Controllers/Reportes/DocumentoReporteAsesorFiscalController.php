<?php

namespace App\Http\Controllers\Reportes;

use App\Services\Reportes\ReporteAsesorFiscalService;

class DocumentoReporteAsesorFiscalController extends BaseReporteController
{
    protected string $vista = 'reportes.documento-asesor-fiscal';

    protected string $servicioReporte = ReporteAsesorFiscalService::class;

    protected string $nombreArchivo = 'reporte_asesor_fiscal';

    protected array $configuracion = [
        'mostrarFiltroAsesor' => true,
        'rutaPdf' => 'reportes.asesor-fiscal.pdf',
    ];
}