<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisplayVideo extends Model
{
    protected $fillable = [
        'nombre',
        'archivo',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}
