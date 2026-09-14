<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Services\Reportes\ModeloReporteOrientadorFiscalService;
use Illuminate\Http\Request;
use App\Models\User;

class DocumentoReporteOrientadorFiscalController extends Controller
{
    public function __construct(
        private ModeloReporteOrientadorFiscalService $modeloReporteService
    ) {
    }

    public function index(Request $request)
    {
        $usuario = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Orientadores disponibles
        |--------------------------------------------------------------------------
        | Se utilizan únicamente para que el Administrador pueda seleccionar
        | un Orientador Fiscal.
        */
        $orientadores = User::role('Orientador Fiscal')
            ->orderBy('nombre')
            ->orderBy('apellido_paterno')
            ->orderBy('apellido_materno')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Determinar Orientador
        |--------------------------------------------------------------------------
        |
        | Orientador Fiscal:
        |   Siempre consulta su propio reporte.
        |
        | Administrador:
        |   Puede seleccionar el Orientador mediante orientador_id.
        |
        */
        if ($usuario->hasRole('Orientador Fiscal')) {

            $orientadorId = $usuario->id;

        } else {

            $orientadorId = $request->integer('orientador_id');

        }


        /*
        |--------------------------------------------------------------------------
        | Fechas
        |--------------------------------------------------------------------------
        */

        $fechaInicio = $request->input(
            'inicio',
            now()->startOfMonth()->format('Y-m-d')
        );

        $fechaFin = $request->input(
            'fin',
            now()->endOfMonth()->format('Y-m-d')
        );


        /*
        |--------------------------------------------------------------------------
        | Modelo
        |--------------------------------------------------------------------------
        */

        $modelo = null;

        if ($orientadorId > 0) {

            $modelo = $this->modeloReporteService->construirModelo(
                fechaInicio: $fechaInicio,
                fechaFin: $fechaFin,
                orientadorId: $orientadorId
            );

        }


        return view(
            'reportes.documento-orientador-fiscal',
            [
                'modelo' => $modelo,

                'fechaInicio' => $fechaInicio,

                'fechaFin' => $fechaFin,

                'orientadorId' => $orientadorId ?: null,

                'orientadores' => $orientadores,

                'esAdministrador' => $usuario->hasRole('Administrador'),

                'esOrientador' => $usuario->hasRole('Orientador Fiscal'),
            ]
        );
    }

    public function pdf(Request $request)
    {
        $usuario = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Determinar Orientador
        |--------------------------------------------------------------------------
        */

        if ($usuario->hasRole('Orientador Fiscal')) {

            $orientadorId = $usuario->id;

        } else {

            $orientadorId = $request->integer('orientador_id');

        }


        if ($orientadorId <= 0) {

            abort(400, 'Debe seleccionar un Orientador Fiscal.');

        }


        /*
        |--------------------------------------------------------------------------
        | Fechas
        |--------------------------------------------------------------------------
        */

        $fechaInicio = $request->input(
            'inicio',
            now()->startOfMonth()->format('Y-m-d')
        );

        $fechaFin = $request->input(
            'fin',
            now()->endOfMonth()->format('Y-m-d')
        );


        /*
        |--------------------------------------------------------------------------
        | Construir modelo
        |--------------------------------------------------------------------------
        */

        $modelo = $this->modeloReporteService->construirModelo(
            fechaInicio: $fechaInicio,
            fechaFin: $fechaFin,
            orientadorId: $orientadorId
        );


        /*
        |--------------------------------------------------------------------------
        | Generar PDF
        |--------------------------------------------------------------------------
        */

        $html = view(
            'reportes.pdf-orientador-fiscal',
            [
                'modelo' => $modelo,
            ]
        )->render();


        $pdf = app(\App\Services\Reportes\ReportePdfService::class)
            ->generarDesdeHtml(
                html: $html
            );


        $nombreArchivo = 'reporte_orientador_fiscal_'
            .$fechaInicio
            .'_al_'.$fechaFin
            .'.pdf';


        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header(
                'Content-Disposition',
                'inline; filename="'.$nombreArchivo.'"'
            );
    }
}