<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modalidad;
use App\Models\EstatusTurno;
use App\Models\EstatusModulo;
use App\Models\TipoTramite;
use App\Models\ClasificacionTramite;

class CatalogosBaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Modalidades
        |--------------------------------------------------------------------------
        */

        Modalidad::insert([
            [
                'id' => 1,
                'nombre' => 'PRESENCIAL',
                'prefijo' => 'P',
                'activo' => true,
            ],
            [
                'id' => 2,
                'nombre' => 'VIA TELEFONICA',
                'prefijo' => 'T',
                'activo' => true,
            ],
            [
                'id' => 3,
                'nombre' => 'VIA CORREO ELECTRONICO',
                'prefijo' => 'C',
                'activo' => true,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Estatus de Turnos
        |--------------------------------------------------------------------------
        */

        EstatusTurno::insert([
            ['id' => 1, 'nombre' => 'EN ESPERA', 'activo' => true],
            ['id' => 2, 'nombre' => 'EN ATENCION', 'activo' => true],
            ['id' => 3, 'nombre' => 'ATENDIDO', 'activo' => true],
            ['id' => 4, 'nombre' => 'CANCELADO', 'activo' => true],
            ['id' => 5, 'nombre' => 'INCONCLUSO', 'activo' => true],
            ['id' => 6, 'nombre' => 'NO SE PRESENTÓ', 'activo' => true],
            ['id' => 7, 'nombre' => 'LLAMADO', 'activo' => true],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Estatus de Módulos
        |--------------------------------------------------------------------------
        */

        EstatusModulo::insert([
            ['id' => 1, 'nombre' => 'DISPONIBLE', 'activo' => true],
            ['id' => 2, 'nombre' => 'ATENDIENDO', 'activo' => true],
            ['id' => 3, 'nombre' => 'AUSENTE', 'activo' => true],
            ['id' => 4, 'nombre' => 'CERRADO', 'activo' => true],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Tipos de Trámite
        |--------------------------------------------------------------------------
        */

        $tipos = [
            1 => 'TRÁMITES RÉGIMEN DE INCORPORACIÓN FISCAL',
            2 => 'TRÁMITES ESTATALES',
            3 => 'TRÁMITES FEDERALES',
        ];

        foreach ($tipos as $id => $nombre) {
            TipoTramite::updateOrCreate(
                ['id' => $id],
                [
                    'nombre' => $nombre,
                    'activo' => true,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Clasificaciones de Trámite
        |--------------------------------------------------------------------------
        */

        $clasificaciones = [
            [1, 1, 'TRÁMITES AUTOSERVICIO'],
            [1, 2, 'MIS CUENTAS'],

            [2, 1, 'INSCRIPCIÓN DE IMPUESTOS ESTATALES'],
            [2, 2, 'REANUDACIÓN DE ACTIVIDADES DE IMPUESTOS ESTATALES'],
            [2, 3, 'CAMBIO DE DOMICILIO DE IMPUESTOS ESTATALES'],
            [2, 4, 'SUSPENSIÓN DE ACTIVIDADES DE IMPUESTOS ESTATALES'],
            [2, 5, 'DECLARACION DE IMPUESTOS ESTATALES'],
            [2, 6, 'ASESORÍA DE IMPUESTOS ESTATALES'],
            [2, 7, 'REFRENDO VEHICULAR'],
            [2, 8, 'SOLVENTACIÓN DE REQUERIMIENTO DE IMPUESTOS ESTATALES'],
            [2, 9, 'SOLVENTACIÓN DE EXHORTOS, AVISOS E INVITACIONES'],

            [3, 1, 'SOLVENTACIÓN DE REQUERIMIENTO DE IMPUESTOS FEDERAL'],
        ];

        foreach ($clasificaciones as [$tipoTramiteId, $numero, $nombre]) {
            ClasificacionTramite::updateOrCreate(
                [
                    'tipo_tramite_id' => $tipoTramiteId,
                    'numero' => $numero,
                ],
                [
                    'nombre' => $nombre,
                    'activo' => true,
                ]
            );
        }
    }
}