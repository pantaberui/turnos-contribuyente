<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClasificacionTramite extends Model
{
    protected $table = 'clasificacion_tramites';

    protected $fillable = [
        'tipo_tramite_id',
        'numero',
        'nombre',
        'activo',
    ];

    public function tipoTramite()
    {
        return $this->belongsTo(TipoTramite::class);
    }

    public function tramites()
    {
        return $this->hasMany(Tramite::class)
            ->where('activo', true)
            ->orderBy('numero');
    }
}