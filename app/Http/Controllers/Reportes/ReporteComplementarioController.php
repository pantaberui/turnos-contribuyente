<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Services\Reportes\ReporteComplementarioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReporteComplementarioController extends Controller
{
    private ReporteComplementarioService $reporteComplementarioService;

    public function __construct(
        ReporteComplementarioService $reporteComplementarioService
    ) {
        $this->reporteComplementarioService = $reporteComplementarioService;
    }

    public function guardar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'asesor_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'fecha_inicio' => [
                'required',
                'date',
            ],

            'fecha_fin' => [
                'required',
                'date',
                'after_or_equal:fecha_inicio',
            ],

            'tipo_periodo' => [
                'required',
                'string',
                'max:30',
            ],

            'talleres_rif' => [
                'required',
                'integer',
                'min:0',
            ],

            'talleres_estatales' => [
                'required',
                'integer',
                'min:0',
            ],

            'proyectos_realizados' => [
                'required',
                'integer',
                'min:0',
            ],

            'actividades_adicionales' => [
                'nullable',
                'string',
            ],
        ]);

        $this->reporteComplementarioService->guardar(
            asesorId: (int) $datos['asesor_id'],
            fechaInicio: $datos['fecha_inicio'],
            fechaFin: $datos['fecha_fin'],
            datos: $datos,
            capturadoPor: auth()->id()
        );

        return redirect()
            ->back()
            ->with('success', 'Los datos complementarios del reporte fueron guardados correctamente.');
    }
}