<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    //
    protected $fillable = [
        'tipo_tramite_id',
        'clasificacion_tramite_id',
        'nombre',
        'categoria',
        'requiere_declaracion',
        'activo',
    ];
}
