<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Reportes\ModeloReporteService;
use App\Services\Reportes\ReporteAsesorFiscalService;
use App\Services\Reportes\ReportePdfService;

class DocumentoReporteAsesorFiscalController extends Controller
{
    public function index()
    {
        return view('reportes.documento-asesor-fiscal', $this->construirDatosReporte() + [
            'modoPdf' => false,
        ]);
    }

    public function pdf()
    {
        $data = $this->construirDatosReporte();

        $html = view('reportes.documento-asesor-fiscal', $data + [
            'modoPdf' => true,
        ])->render();

        $headerHtml = view('reportes.pdf.encabezado', $data)->render();

        $footerHtml = view('reportes.pdf.pie', $data)->render();

        $pdf = app(ReportePdfService::class)->generarDesdeHtml(
            html: $html,
            headerHtml: $headerHtml,
            footerHtml: $footerHtml
        );

        $nombreArchivo = 'reporte_asesor_fiscal_' .
            $data['fechaInicio'] . '_al_' . $data['fechaFin'] . '.pdf';

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="'.$nombreArchivo.'"');
    }

    private function construirDatosReporte(): array
    {
        $fechaInicio = request('inicio', '2026-06-01');
        $fechaFin = request('fin', '2026-06-30');
        $tipoPeriodo = request('periodo', 'Mensual');
        $asesorId = request('asesor_id');
        $modalidad = request('modalidad');

        $asesores = User::role([
            'Asesor Fiscal',
            'Orientador Fiscal',
        ])->orderBy('name')->get();

        $asesorSeleccionado = $asesorId
            ? User::find($asesorId)
            : null;

        $modelo = app(ModeloReporteService::class)->construirModelo(
            fechaInicio: $fechaInicio,
            fechaFin: $fechaFin,
            tipoPeriodo: $tipoPeriodo,
            asesorId: $asesorId ? (int) $asesorId : null,
            modalidad: $modalidad ?: null
        );

        $modelo['consulta']['asesor'] = $asesorSeleccionado
            ? mb_strtoupper($asesorSeleccionado->name, 'UTF-8')
            : 'TODOS';

        $modelo['consulta']['modalidad'] = match ($modalidad) {
            'PRESENCIAL' => 'PRESENCIAL',
            'TELEFONICA' => 'TELEFÓNICA',
            'CORREO' => 'CORREO ELECTRÓNICO',
            default => 'TODAS',
        };

        $reporte = app(ReporteAsesorFiscalService::class)->construir($modelo);

        return compact(
            'reporte',
            'fechaInicio',
            'fechaFin',
            'tipoPeriodo',
            'asesores',
            'asesorId',
            'modalidad'
        );
    }
}