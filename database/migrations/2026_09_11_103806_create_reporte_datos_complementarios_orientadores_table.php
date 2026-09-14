<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reporte_datos_complementarios_orientadores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('orientador_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            $table->string('tipo_periodo', 30)->default('Mensual');

            $table->text('actividades_adicionales')->nullable();

            $table->foreignId('capturado_por')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->unique(
                ['orientador_id', 'fecha_inicio', 'fecha_fin'],
                'reporte_complementario_orientador_periodo_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_datos_complementarios_orientadores');
    }
};