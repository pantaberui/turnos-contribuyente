<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReporteDatoComplementarioOrientador extends Model
{
    protected $table = 'reporte_datos_complementarios_orientadores';

    protected $fillable = [
        'orientador_id',
        'fecha_inicio',
        'fecha_fin',
        'tipo_periodo',
        'actividades_adicionales',
        'capturado_por',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function orientador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'orientador_id');
    }

    public function capturadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'capturado_por');
    }
}