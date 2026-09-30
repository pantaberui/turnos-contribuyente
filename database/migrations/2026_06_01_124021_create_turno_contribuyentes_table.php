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
        Schema::create('turno_contribuyentes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('turno_id')
                ->constrained('turnos')
                ->cascadeOnDelete();

            $table->foreignId('contribuyente_id')
                ->constrained('contribuyentes');

            $table->boolean('es_principal')->default(false);

            $table->unsignedInteger('orden')->default(1);

            $table->timestamps();

            $table->unique(['turno_id', 'contribuyente_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('turno_contribuyentes');
    }    
};
