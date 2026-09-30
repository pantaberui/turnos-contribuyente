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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('contribuyente_id')
                ->constrained('contribuyentes');

            $table->foreignId('orientador_id')
                ->constrained('users');

            $table->foreignId('modalidad_id')
                ->constrained('modalidades');

            $table->date('fecha');

            $table->unsignedInteger('numero_asistencia');

            $table->time('hora_inicio');
            $table->time('hora_fin')->nullable();

            $table->integer('tiempo_orientacion_segundos')->default(0);

            $table->boolean('requiere_turno')->default(false);

            $table->text('observaciones')->nullable();

            $table->json('lista_contribuyentes')->nullable();

            // Datos solo para modalidad telefónica
            $table->string('ciudad_origen_llamada')->nullable();
            $table->string('pais_origen_llamada')->nullable();
            $table->string('codigo_pais_llamada', 10)->nullable();
            $table->string('telefono_origen_llamada', 25)->nullable();
            $table->string('cuenta_estatal_capturada', 50)->nullable();

            $table->timestamps();

            $table->unique(['fecha', 'numero_asistencia']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
