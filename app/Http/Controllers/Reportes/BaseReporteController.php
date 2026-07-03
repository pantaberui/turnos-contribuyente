<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Reportes\ModeloReporteService;
use App\Services\Reportes\ReportePdfService;
use Carbon\Carbon;

abstract class BaseReporteController extends Controller
{
    protected string $vista;
    protected string $servicioReporte;
    protected string $nombreArchivo;
    protected array $configuracion = [];

    public function index()
    {
        return view($this->vista, $this->construirDatosReporte() + [
            'modoPdf' => false,
        ]);
    }

    public function pdf()
    {
        $data = $this->construirDatosReporte();

        $html = view($this->vista, $data + [
            'modoPdf' => true,
        ])->render();

        $headerHtml = view('reportes.pdf.encabezado', $data)->render();
        $footerHtml = view('reportes.pdf.pie', $data)->render();

        $pdf = app(ReportePdfService::class)->generarDesdeHtml(
            html: $html,
            headerHtml: $headerHtml,
            footerHtml: $footerHtml
        );

        $nombreArchivo = $this->nombreArchivo.'_';
            $data['fechaInicio'].'_al_'.$data['fechaFin'].'.pdf';

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="'.$nombreArchivo.'"');
    }

    protected function construirDatosReporte(?int $asesorIdForzado = null): array
    {
        $tipoPeriodo = request('periodo', 'Mensual');
        $modalidad = request('modalidad');
        $asesorId = $asesorIdForzado ?? request('asesor_id');

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

        $reporte = app($this->servicioReporte)->construir($modelo);
        $configuracion = $this->configuracion;

        return compact(
            'reporte',
            'fechaInicio',
            'fechaFin',
            'tipoPeriodo',
            'asesores',
            'asesorId',
            'modalidad',
            'configuracion'
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