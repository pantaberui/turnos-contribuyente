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
        // Modalidades
        Modalidad::insert([
            [
                'nombre' => 'PRESENCIAL',
                'prefijo' => 'P',
                'activo' => true,
            ],
            [
                'nombre' => 'VIA TELEFONICA',
                'prefijo' => 'T',
                'activo' => true,
            ],
            [
                'nombre' => 'VIA CORREO ELECTRONICO',
                'prefijo' => 'C',
                'activo' => true,
            ],
        ]);

        // Estatus de Turnos
        EstatusTurno::insert([
            ['nombre' => 'EN ESPERA', 'activo' => true],
            ['nombre' => 'EN ATENCION', 'activo' => true],
            ['nombre' => 'ATENDIDO', 'activo' => true],
            ['nombre' => 'CANCELADO', 'activo' => true],
            ['nombre' => 'INCONCLUSO', 'activo' => true],
        ]);

        // Estatus de Módulos
        EstatusModulo::insert([
            ['nombre' => 'DISPONIBLE', 'activo' => true],
            ['nombre' => 'ATENDIENDO', 'activo' => true],
            ['nombre' => 'AUSENTE', 'activo' => true],
            ['nombre' => 'CERRADO', 'activo' => true],
        ]);

        // Tipos de Trámite
        $tipos = [
            1 => 'TRÁMITE RÉGIMEN DE INCORPORACIÓN FISCAL',
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

        // Clasificaciones de Trámite
        $clasificaciones = [
            [1, 1, 'TRÁMITES AUTOSERVICIO'],
            [1, 2, 'MIS CUENTAS'],

            [2, 1, 'INSCRIPCIÓN DE IMPUESTOS ESTATALES'],
            [2, 2, 'REANUDACIÓN DE ACTIVIDADES DE IMPUESTOS ESTATALES'],
            [2, 3, 'CAMBIO DE DOMICILIO DE IMPUESTOS ESTATALES'],
            [2, 4, 'SUSPENSIÓN DE ACTIVIDADES DE IMPUESTOS ESTATALES'],
            [2, 5, 'INSCRIPCIÓN DE IMPUESTOS ESTATALES'],
            [2, 6, 'DECLARACIÓN DE IMPUESTOS ESTATALES'],
            [2, 7, 'ASESORÍA DE IMPUESTOS ESTATALES'],
            [2, 8, 'REFRENDO VEHICULAR'],
            [2, 9, 'SOLVENTACIÓN DE REQUERIMIENTO DE IMPUESTOS ESTATAL'],
            [2, 10, 'SOLVENTANCIÓN DE EXHORTOS, AVISOS E INVITACIONES'],

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