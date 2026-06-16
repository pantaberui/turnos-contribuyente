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
        Schema::create('asesorias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('turno_id')
                ->nullable()
                ->constrained('turnos')
                ->nullOnDelete();

            $table->foreignId('contribuyente_id')
                ->nullable()
                ->constrained('contribuyentes')
                ->nullOnDelete();

            $table->foreignId('asesor_id')
                ->constrained('users');

            $table->enum('modalidad', [
                'PRESENCIAL',
                'TELEFONICA',
                'CORREO',
            ]);

            $table->enum('estatus', [
                'INICIADA',
                'FINALIZADA',
                'CANCELADA',
            ])->default('INICIADA');

            $table->timestamp('inicio_atencion');
            $table->timestamp('fin_atencion')->nullable();
            $table->integer('duracion_segundos')->nullable();

            // Datos telefónicos
            $table->string('pais_origen_llamada')->nullable();
            $table->string('ciudad_origen_llamada')->nullable();
            $table->string('telefono_origen_llamada')->nullable();

            // Datos correo
            $table->string('correo_origen')->nullable();
            $table->string('asunto_correo')->nullable();

            $table->text('observaciones')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('modalidad');
            $table->index('estatus');
            $table->index('asesor_id');
            $table->index('inicio_atencion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesorias');
    }
};
