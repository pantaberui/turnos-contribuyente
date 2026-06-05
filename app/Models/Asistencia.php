<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contribuyente;
use App\Models\Modalidad;


class Asistencia extends Model
{
    protected $fillable = [
        'contribuyente_id',
        'orientador_id',
        'modalidad_id',
        'fecha',
        'numero_asistencia',
        'hora_inicio',
        'hora_fin',
        'tiempo_orientacion_segundos',
        'requiere_turno',
        'tipo_tramite_id',
        'observaciones',
        'lista_contribuyentes',
        'ciudad_origen_llamada',
        'pais_origen_llamada',
        'codigo_pais_llamada',
        'telefono_origen_llamada',
        'cuenta_estatal_capturada',
    ];

    protected $casts = [
        'fecha' => 'date',
        'requiere_turno' => 'boolean',
        'lista_contribuyentes' => 'array',
    ];

    public function contribuyente()
    {
        return $this->belongsTo(Contribuyente::class);
    }

    public function modalidad()
    {
        return $this->belongsTo(Modalidad::class);
    }

    public function orientador()
    {
        return $this->belongsTo(User::class, 'orientador_id');
    }
}


