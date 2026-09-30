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
        Schema::create('asesoria_contribuyentes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asesoria_id')
                ->constrained('asesorias')
                ->cascadeOnDelete();

            $table->foreignId('contribuyente_id')
                ->constrained('contribuyentes')
                ->cascadeOnDelete();

            $table->boolean('es_principal')->default(false);
            $table->unsignedInteger('orden')->default(1);

            $table->timestamps();

            $table->unique(['asesoria_id', 'contribuyente_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesoria_contribuyentes');
    }
};
