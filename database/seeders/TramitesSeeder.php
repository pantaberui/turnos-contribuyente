<?php

namespace Database\Seeders;

use App\Models\ClasificacionTramite;
use App\Models\Tramite;
use Illuminate\Database\Seeder;

class TramitesSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/tramites.csv');

        if (! file_exists($path)) {
            throw new \RuntimeException("No existe el archivo: {$path}");
        }

        $file = fopen($path, 'r');

        // Saltar encabezados
        fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            [
                $tipoTramiteId,
                $clasificacionNumero,
                $nombre,
                $requiereDeclaracion,
                $categoria,
                $activo,
            ] = $row;

            $clasificacion = ClasificacionTramite::where('tipo_tramite_id', $tipoTramiteId)
                ->where('numero', $clasificacionNumero)
                ->firstOrFail();

            Tramite::updateOrCreate(
                [
                    'tipo_tramite_id' => $tipoTramiteId,
                    'clasificacion_tramite_id' => $clasificacion->id,
                    'nombre' => mb_strtoupper(trim($nombre), 'UTF-8'),
                ],
                [
                    'categoria' => mb_strtoupper(trim($categoria), 'UTF-8'),
                    'requiere_declaracion' => (bool) $requiereDeclaracion,
                    'activo' => (bool) $activo,
                ]
            );
        }

        fclose($file);
    }
}
