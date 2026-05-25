<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClasificacionTramite extends Model
{
    //
    protected $fillable = [
        'idTipoTramite',
        'idClasificacionTramite',
        'clasificacioneTramite',
    ];
}
