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
        Schema::create('modulo_asesorias', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 100);

            $table->string('descripcion', 255)->nullable();

            $table->foreignId('estatus_modulo_id')
                ->constrained('estatus_modulos');

            $table->foreignId('asesor_id')
                ->nullable()
                ->constrained('users');

            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modulo_asesorias');
    }
};
