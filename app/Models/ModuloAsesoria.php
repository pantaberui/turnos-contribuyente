<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ModuloAsesoria extends Model
{
    protected $table = 'modulo_asesorias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estatus_modulo_id',
        'asesor_id',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function asesor()
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }

    public function estatusModulo()
    {
        return $this->belongsTo(EstatusModulo::class);
    }
}
