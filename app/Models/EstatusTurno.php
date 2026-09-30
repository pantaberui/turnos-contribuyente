<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstatusTurno extends Model
{
    protected $table = 'estatus_turnos';

    protected $fillable = [
        'nombre',
        'activo',
    ];
}