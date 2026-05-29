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
        Schema::create('turnos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asistencia_id')
                ->constrained('asistencias');

            $table->foreignId('contribuyente_id')
                ->constrained('contribuyentes');

            $table->foreignId('modalidad_id')
                ->constrained('modalidades');

            $table->foreignId('estatus_turno_id')
                ->constrained('estatus_turnos');

            $table->date('fecha');

            $table->unsignedInteger('numero');

            $table->string('folio', 20);

            $table->time('hora_generado');

            $table->time('hora_llamado')->nullable();

            $table->time('hora_inicio_atencion')->nullable();

            $table->time('hora_fin_atencion')->nullable();

            $table->integer('tiempo_espera_segundos')->default(0);

            $table->integer('tiempo_atencion_segundos')->default(0);

            $table->timestamps();

            $table->unique(['fecha', 'modalidad_id', 'numero']);
            $table->unique(['fecha', 'folio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turnos');
    }
};
