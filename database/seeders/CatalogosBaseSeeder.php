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

        $modalidades = [
            [1, 'PRESENCIAL', 'P'],
            [2, 'VIA TELEFONICA', 'T'],
            [3, 'VIA CORREO ELECTRONICO', 'C'],
        ];

        foreach ($modalidades as [$id, $nombre, $prefijo]) {
            Modalidad::updateOrCreate(
                ['id' => $id],
                [
                    'nombre' => $nombre,
                    'prefijo' => $prefijo,
                    'activo' => true,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Estatus de Turnos
        |--------------------------------------------------------------------------
        */

        $estatusTurnos = [
            [1, 'EN ESPERA'],
            [2, 'EN ATENCION'],
            [3, 'ATENDIDO'],
            [4, 'CANCELADO'],
            [5, 'INCONCLUSO'],
            [6, 'NO SE PRESENTÓ'],
            [7, 'LLAMADO'],
        ];

        foreach ($estatusTurnos as [$id, $nombre]) {
            EstatusTurno::updateOrCreate(
                ['id' => $id],
                [
                    'nombre' => $nombre,
                    'activo' => true,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Estatus de Módulos
        |--------------------------------------------------------------------------
        */

        $estatusModulos = [
            [1, 'DISPONIBLE'],
            [2, 'ATENDIENDO'],
            [3, 'AUSENTE'],
            [4, 'CERRADO'],
        ];

        foreach ($estatusModulos as [$id, $nombre]) {
            EstatusModulo::updateOrCreate(
                ['id' => $id],
                [
                    'nombre' => $nombre,
                    'activo' => true,
                ]
            );
        }

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

        /*
        |--------------------------------------------------------------------------
        | Trámites
        |--------------------------------------------------------------------------
        */

        $this->call(TramitesSeeder::class);
    }
}