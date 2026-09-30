<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TurnoContribuyente extends Model
{
    protected $table = 'turno_contribuyentes';

    protected $fillable = [
        'turno_id',
        'contribuyente_id',
        'es_principal',
        'orden',
    ];

    protected $casts = [
        'es_principal' => 'boolean',
    ];

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }

    public function contribuyente()
    {
        return $this->belongsTo(Contribuyente::class);
    }
}
