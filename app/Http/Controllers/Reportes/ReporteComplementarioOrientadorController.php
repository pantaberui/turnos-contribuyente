<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Services\Reportes\ReporteComplementarioOrientadorService;
use Illuminate\Http\Request;

class ReporteComplementarioOrientadorController extends Controller
{
    public function guardar(
        Request $request,
        ReporteComplementarioOrientadorService $service
    ) {
        $usuario = $request->user();

        $orientadorId = $request->integer('orientador_id');

        /*
        |--------------------------------------------------------------------------
        | Orientador Fiscal
        |--------------------------------------------------------------------------
        | Solo puede guardar información de su propio reporte.
        */
        if ($usuario->hasRole('Orientador Fiscal')) {
            $orientadorId = $usuario->id;
        }

        /*
        |--------------------------------------------------------------------------
        | Validación
        |--------------------------------------------------------------------------
        */
        $datos = $request->validate([
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],
            'tipo_periodo' => ['nullable', 'string', 'max:30'],
            'actividades_adicionales' => ['nullable', 'string', 'max:3000'],
        ]);

        $service->guardar(
            orientadorId: $orientadorId,
            fechaInicio: $datos['fecha_inicio'],
            fechaFin: $datos['fecha_fin'],
            datos: [
                'tipo_periodo' => $datos['tipo_periodo'] ?? 'Mensual',
                'actividades_adicionales' =>
                    $datos['actividades_adicionales'] ?? null,
            ],
            capturadoPor: $usuario->id
        );

        return redirect()
            ->route('reportes.orientador-fiscal.documento', [
                'orientador_id' => $orientadorId,
                'inicio' => $datos['fecha_inicio'],
                'fin' => $datos['fecha_fin'],
            ])
            ->with('success', 'Datos complementarios guardados correctamente.');
    }
}