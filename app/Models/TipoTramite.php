<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ClasificacionTramite;

class TipoTramite extends Model
{
    protected $table = 'tipo_tramites';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function clasificaciones()
    {
        return $this->hasMany(ClasificacionTramite::class);
    }
}