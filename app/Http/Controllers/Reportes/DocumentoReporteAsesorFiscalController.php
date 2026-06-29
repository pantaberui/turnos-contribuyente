<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Services\Reportes\ReporteAsesorFiscalService;
use App\Services\Reportes\ModeloReporteService;
use App\Models\User;

class DocumentoReporteAsesorFiscalController extends Controller
{
    public function index()
    {
        $fechaInicio = request('inicio', '2026-06-01');
        $fechaFin = request('fin', '2026-06-30');
        $tipoPeriodo = request('periodo', 'Mensual');
        $modalidad = request('modalidad');

        $asesorId = request('asesor_id');

        $asesorSeleccionado = $asesorId
            ? User::find($asesorId)
            : null;

        $asesores = User::role([
            'Asesor Fiscal',
            'Orientador Fiscal',
        ])->orderBy('name')->get();

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

        return view('reportes.documento-asesor-fiscal', compact(
            'reporte',
            'fechaInicio',
            'fechaFin',
            'tipoPeriodo',
            'asesores',
            'asesorId',
            'modalidad'
        ));
    }



}