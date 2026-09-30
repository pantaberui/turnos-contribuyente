<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstatusModulo extends Model
{
    protected $table = 'estatus_modulos';

    protected $fillable = [
        'nombre',
        'activo',
    ];
}