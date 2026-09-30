<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asesoria extends Model
{
    protected $fillable = [
        'turno_id',
        'contribuyente_id',
        'asesor_id',
        'modalidad',
        'estatus',
        'inicio_atencion',
        'fin_atencion',
        'duracion_segundos',

        'pais_origen_llamada',
        'ciudad_origen_llamada',
        'telefono_origen_llamada',

        'correo_origen',
        'asunto_correo',
        'fecha_hora_recepcion_correo',

        'observaciones',

        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'inicio_atencion' => 'datetime',
        'fin_atencion' => 'datetime',
        'fecha_hora_recepcion_correo' => 'datetime',
    ];

    public function turno(): BelongsTo
    {
        return $this->belongsTo(Turno::class);
    }

    public function contribuyente(): BelongsTo
    {
        return $this->belongsTo(Contribuyente::class);
    }

    public function asesor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function actualizador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function tramites()
    {
        return $this->hasMany(AsesoriaTramite::class);
    }

    public function contribuyentes()
    {
        return $this->hasMany(AsesoriaContribuyente::class);
    }
}
