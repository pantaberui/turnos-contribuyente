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
        Schema::create('asesoria_tramites', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asesoria_id')
                ->constrained('asesorias')
                ->cascadeOnDelete();

            $table->foreignId('contribuyente_id')
                ->constrained('contribuyentes')
                ->cascadeOnDelete();

            $table->foreignId('tramite_id')
                ->constrained('tramites')
                ->cascadeOnDelete();

            $table->integer('cantidad')
                ->default(1);

            $table->decimal('importe_declaracion', 12, 2)
                ->nullable();

            $table->timestamps();

            $table->index('asesoria_id');
            $table->index('contribuyente_id');
            $table->index('tramite_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesoria_tramites');
    }
};