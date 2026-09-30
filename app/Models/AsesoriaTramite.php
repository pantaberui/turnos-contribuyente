<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsesoriaTramite extends Model
{
    protected $table = 'asesoria_tramites';

    protected $fillable = [
        'asesoria_id',
        'contribuyente_id',
        'tramite_id',
        'cantidad',
        'importe_declaracion',
    ];

    public function asesoria()
    {
        return $this->belongsTo(Asesoria::class);
    }

    public function contribuyente()
    {
        return $this->belongsTo(Contribuyente::class);
    }

    public function tramite()
    {
        return $this->belongsTo(Tramite::class);
    }
}

