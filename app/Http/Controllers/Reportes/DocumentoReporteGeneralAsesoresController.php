<?php

namespace App\Http\Controllers\Reportes;

use App\Services\Reportes\ReporteGeneralAsesoresService;

class DocumentoReporteGeneralAsesoresController extends BaseReporteController
{
    protected string $vista = 'reportes.documento-general-asesores';

    protected string $servicioReporte = ReporteGeneralAsesoresService::class;

    protected string $nombreArchivo = 'reporte_general_asesores';

    protected array $configuracion = [
        'mostrarFiltroAsesor' => false,
        'rutaPdf' => 'reportes.general-asesores.pdf',
    ];
}