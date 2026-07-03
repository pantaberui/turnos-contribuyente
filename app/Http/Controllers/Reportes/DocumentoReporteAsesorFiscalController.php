<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Reportes\ModeloReporteService;
use App\Services\Reportes\ReporteAsesorFiscalService;
use App\Services\Reportes\ReportePdfService;
use Carbon\Carbon;

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
        $asesorId = request('asesor_id');
        $modalidad = request('modalidad');
        $tipoPeriodo = request('periodo', 'Mensual');

        $fechaInicio = request('inicio');
        $fechaFin = request('fin');

        if ($tipoPeriodo !== 'Personalizado') {
            [$fechaInicio, $fechaFin] = $this->obtenerFechasPeriodo($tipoPeriodo);
        }

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

    private function obtenerFechasPeriodo(string $periodo): array
    {
        $hoy = Carbon::today();

        return match ($periodo) {

            'Semanal' => [
                $hoy->copy()->startOfWeek()->format('Y-m-d'),
                $hoy->copy()->endOfWeek()->format('Y-m-d'),
            ],

            'Quincenal' => $hoy->day <= 15
                ? [
                    $hoy->copy()->startOfMonth()->format('Y-m-d'),
                    $hoy->copy()->day(15)->format('Y-m-d'),
                ]
                : [
                    $hoy->copy()->day(16)->format('Y-m-d'),
                    $hoy->copy()->endOfMonth()->format('Y-m-d'),
                ],

            'Mensual' => [
                $hoy->copy()->startOfMonth()->format('Y-m-d'),
                $hoy->copy()->endOfMonth()->format('Y-m-d'),
            ],

            default => [
                $hoy->format('Y-m-d'),
                $hoy->format('Y-m-d'),
            ],
        };
    }
}