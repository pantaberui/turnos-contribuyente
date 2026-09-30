<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Reportes\ModeloReporteGeneralOrientadoresService;
use Illuminate\Http\Request;

class DocumentoReporteGeneralOrientadoresController extends Controller
{
    public function __construct(
        private ModeloReporteGeneralOrientadoresService $modeloReporteService
    ) {
    }

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Orientadores disponibles
        |--------------------------------------------------------------------------
        */

        $orientadores = User::role('Orientador Fiscal')
            ->orderBy('nombre')
            ->orderBy('apellido_paterno')
            ->orderBy('apellido_materno')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Filtro de Orientador
        |--------------------------------------------------------------------------
        |
        | null = todos
        | id   = orientador específico
        |
        */

        $orientadorId = $request->integer('orientador_id') ?: null;


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

        $modelo = $this->modeloReporteService->construirModelo(
            fechaInicio: $fechaInicio,
            fechaFin: $fechaFin,
            orientadorId: $orientadorId
        );


        return view(
            'reportes.documento-general-orientadores',
            [
                'modelo' => $modelo,

                'fechaInicio' => $fechaInicio,

                'fechaFin' => $fechaFin,

                'orientadorId' => $orientadorId,

                'orientadores' => $orientadores,
            ]
        );
    }

    public function pdf(Request $request)
    {
        $orientadorId = $request->integer('orientador_id') ?: null;

        $fechaInicio = $request->input(
            'inicio',
            now()->startOfMonth()->format('Y-m-d')
        );

        $fechaFin = $request->input(
            'fin',
            now()->endOfMonth()->format('Y-m-d')
        );

        $modelo = $this->modeloReporteService->construirModelo(
            fechaInicio: $fechaInicio,
            fechaFin: $fechaFin,
            orientadorId: $orientadorId
        );

        $html = view(
            'reportes.pdf-general-orientadores',
            [
                'modelo' => $modelo,
            ]
        )->render();

        $pdf = app(\App\Services\Reportes\ReportePdfService::class)
            ->generarDesdeHtml(
                html: $html
            );

        $nombreArchivo = 'reporte_general_orientadores_'
            .$fechaInicio
            .'_al_'
            .$fechaFin
            .'.pdf';

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header(
                'Content-Disposition',
                'inline; filename="'.$nombreArchivo.'"'
            );
    }
}