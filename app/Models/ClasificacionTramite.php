<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClasificacionTramite extends Model
{
    //
    protected $fillable = [
        'tipo_tramite_id',
        'numero',
        'nombre',
        'activo',
    ];
}
