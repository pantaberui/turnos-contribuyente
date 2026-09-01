<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReporteDatoComplementario extends Model
{
    protected $table = 'reporte_datos_complementarios';

    protected $fillable = [
        'asesor_id',
        'fecha_inicio',
        'fecha_fin',
        'tipo_periodo',
        'talleres_rif',
        'talleres_estatales',
        'proyectos_realizados',
        'actividades_adicionales',
        'capturado_por',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'talleres_rif' => 'integer',
        'talleres_estatales' => 'integer',
        'proyectos_realizados' => 'integer',
    ];

    public function asesor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }

    public function capturadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'capturado_por');
    }
}
