<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    protected $table = 'tramites';

    public const CATEGORIAS = [
        'ASESORIA' => 'ASESORÍA',
        'DECLARACION_TRAMITE' => 'DECLARACIÓN Y TRÁMITE',
    ];

    protected $fillable = [
        'tipo_tramite_id',
        'clasificacion_tramite_id',
        'numero',
        'nombre',
        'categoria',
        'requiere_declaracion',
        'activo',
    ];

    protected $casts = [
        'requiere_declaracion' => 'boolean',
        'activo' => 'boolean',
    ];

    public function tipoTramite()
    {
        return $this->belongsTo(TipoTramite::class);
    }

    public function clasificacionTramite()
    {
        return $this->belongsTo(ClasificacionTramite::class);
    }
}