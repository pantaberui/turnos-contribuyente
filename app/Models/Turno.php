<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Turno extends Model
{
    protected $fillable = [
        'asistencia_id',
        'contribuyente_id',
        'asesor_id',
        'modalidad_id',
        'estatus_turno_id',
        'fecha',
        'numero',
        'folio',
        'hora_generado',
        'hora_llamado',
        'hora_inicio_atencion',
        'hora_fin_atencion',
        'tiempo_espera_segundos',
        'tiempo_atencion_segundos',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function asesor()
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }

    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class);
    }

    public function contribuyente()
    {
        return $this->belongsTo(Contribuyente::class);
    }

    public function modalidad()
    {
        return $this->belongsTo(Modalidad::class);
    }

    public function estatusTurno()
    {
        return $this->belongsTo(EstatusTurno::class);
    }
}
