<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modalidad;
use App\Models\EstatusTurno;
use App\Models\EstatusModulo;

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
    }
}