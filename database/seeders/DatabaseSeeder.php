<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles y usuarios del sistema
        $this->call(RolesAndUsersSeeder::class);

        // Catálogos base del sistema
        $this->call(CatalogosBaseSeeder::class);
    }
}
