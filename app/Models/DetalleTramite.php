<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleTramite extends Model
{
    protected $table = 'detalle_tramites';

    protected $fillable = [
        'turno_id',
        'contribuyente_id',
        'tramite_id',
        'cantidad',
        'importe_declaracion',
    ];

    public function turno()
    {
        return $this->belongsTo(Turno::class);
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
