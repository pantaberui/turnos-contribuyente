<?php

namespace App\Services\Reportes;

use App\Models\TipoTramite;

class ArbolMaestroService
{
    public function construirArbol(): array
    {
        $tipos = TipoTramite::query()
            ->with([
                'clasificacionesTramite' => function ($query) {
                    $query->where('activo', true)
                        ->orderBy('numero');
                },
                'clasificacionesTramite.tramites' => function ($query) {
                    $query->where('activo', true)
                        ->orderBy('numero');
                },
            ])
            ->where('activo', true)
            ->orderBy('id')
            ->get();

        $arbol = [];

        foreach ($tipos as $tipo) {
           $arbol[$tipo->id] = [

                'catalogo' => [

                    'id' => $tipo->id,
                    'numero' => $tipo->id,
                    'nombre' => $tipo->nombre,
                    'activo' => (bool) $tipo->activo,
                    'nivel' => 1,
                    'path' => (string) $tipo->id,
                ],

                'estadisticas' => $this->estructuraEstadisticas(),

                'clasificaciones' => [],
            ];

            foreach ($tipo->clasificacionesTramite as $clasificacion) {
                $arbol[$tipo->id]['clasificaciones'][$clasificacion->id] = [

                    'catalogo' => [

                        'id' => $clasificacion->id,
                        'numero' => $clasificacion->numero,
                        'nombre' => $clasificacion->nombre,
                        'activo' => (bool) $clasificacion->activo,
                        'nivel' => 2,
                        'path' => $tipo->id.'.'.$clasificacion->numero,
                    ],

                    'estadisticas' => $this->estructuraEstadisticas(),

                    'tramites' => [],
                ];

                foreach ($clasificacion->tramites as $tramite) {
                    $arbol[$tipo->id]['clasificaciones'][$clasificacion->id]['tramites'][$tramite->id] = [

                        'catalogo' => [

                            'id' => $tramite->id,
                            'numero' => $tramite->numero,
                            'nombre' => $tramite->nombre,
                            'categoria' => $tramite->categoria,
                            'requiere_declaracion' => (bool) $tramite->requiere_declaracion,
                            'activo' => (bool) $tramite->activo,
                            'nivel' => 3,
                            'path' => $tipo->id.'.'.$clasificacion->numero.'.'.$tramite->numero,
                        ],

                        'estadisticas' => $this->estructuraEstadisticas(),
                    ];
                }
            }
        }

        return $arbol;
    }

    private function estructuraEstadisticas(): array
    {
        return [
            'PRESENCIAL' => 0,
            'TELEFONICA' => 0,
            'CORREO' => 0,
            'TOTAL' => 0,
            'MONTO_VIRTUAL' => 0,
        ];
    }
}