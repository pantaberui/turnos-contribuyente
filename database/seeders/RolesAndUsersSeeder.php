<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $roles = [
            'Administrador',
            'Orientador Fiscal',
            'Asesor Fiscal',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Usuarios
        |--------------------------------------------------------------------------
        |
        | Contraseña temporal para todos:
        | Turnos2026
        |
        */

        $usuarios = [
            [
                'id' => 1,
                'name' => 'Administrador',
                'nombre' => null,
                'apellido_paterno' => null,
                'apellido_materno' => null,
                'email' => 'admin@turnos.local',
                'activo' => true,
                'rol' => 'Administrador',
            ],
            [
                'id' => 2,
                'name' => 'gloria minerva delgado alvarado',
                'nombre' => 'GLORIA MINERVA',
                'apellido_paterno' => 'DELGADO',
                'apellido_materno' => 'ALVARADO',
                'email' => 'mdelgado@turnos.com',
                'activo' => true,
                'rol' => 'Orientador Fiscal',
            ],
            [
                'id' => 3,
                'name' => 'YAHAiRA LUCERO CASTILLO SOTO',
                'nombre' => 'YAHAIRA LUCERO',
                'apellido_paterno' => 'CASTILLO',
                'apellido_materno' => 'SOTO',
                'email' => 'ycastillo@turnos.com',
                'activo' => true,
                'rol' => 'Orientador Fiscal',
            ],
            [
                'id' => 4,
                'name' => 'roxana elizabeth ibarra ponce',
                'nombre' => 'ROXANA ELIZABETH',
                'apellido_paterno' => 'IBARRA',
                'apellido_materno' => 'PONCE',
                'email' => 'ribarra@turnos.com',
                'activo' => true,
                'rol' => 'Asesor Fiscal',
            ],
            [
                'id' => 5,
                'name' => 'lidia edith espinoza marmolejo',
                'nombre' => 'LIDIA EDITH',
                'apellido_paterno' => 'ESPINOZA',
                'apellido_materno' => 'MARMOLEJO',
                'email' => 'lespinoza@turnos.com',
                'activo' => true,
                'rol' => 'Asesor Fiscal',
            ],
            [
                'id' => 6,
                'name' => 'alejandro casas molina',
                'nombre' => 'ALEJANDRO',
                'apellido_paterno' => 'CASAS',
                'apellido_materno' => 'MOLINA',
                'email' => 'acasas@turnos.com',
                'activo' => true,
                'rol' => 'Asesor Fiscal',
            ],
            [
                'id' => 7,
                'name' => 'ENRIQUE LOZANo ALCANTAR',
                'nombre' => 'ENRIQUE',
                'apellido_paterno' => 'LOZANO',
                'apellido_materno' => 'ALCANTAR',
                'email' => 'elozano@turnos.com',
                'activo' => true,
                'rol' => 'Administrador',
            ],
        ];

        foreach ($usuarios as $datos) {
            $rol = $datos['rol'];

            unset($datos['rol']);

            $usuario = User::updateOrCreate(
                ['id' => $datos['id']],
                [
                    'name' => $datos['name'],
                    'nombre' => $datos['nombre'],
                    'apellido_paterno' => $datos['apellido_paterno'],
                    'apellido_materno' => $datos['apellido_materno'],
                    'email' => $datos['email'],
                    'activo' => $datos['activo'],
                    'password' => Hash::make('Turnos2026'),
                ]
            );

            $usuario->syncRoles([$rol]);
        }
    }
}
