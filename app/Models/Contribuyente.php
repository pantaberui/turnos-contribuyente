<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribuyente extends Model
{
    protected $fillable = [
        'tipo_persona',

        'rfc',
        'curp',

        'nombre',
        'apellido_paterno',
        'apellido_materno',

        'razon_social',

        'correo_electronico',
        'telefono_movil',

        'cuenta_estatal',

        'requiere_representante_legal',

        'nombre_representante_legal',
        'curp_representante_legal',
        'telefono_representante_legal',

        'tipo_identificacion',
        'clave_identificacion',

        'activo',

        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'requiere_representante_legal' => 'boolean',
    ];
}
