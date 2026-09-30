<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsesoriaContribuyente extends Model
{
    protected $fillable = [
        'asesoria_id',
        'contribuyente_id',
        'es_principal',
        'orden',
    ];

    public function asesoria()
    {
        return $this->belongsTo(Asesoria::class);
    }

    public function contribuyente()
    {
        return $this->belongsTo(Contribuyente::class);
    }
}
