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
        Schema::create('detalle_tramites', function (Blueprint $table) {

            $table->id();

            $table->foreignId('turno_id')
                ->constrained('turnos')
                ->cascadeOnDelete();

            $table->foreignId('contribuyente_id')
                ->constrained('contribuyentes');

            $table->foreignId('tramite_id')
                ->constrained('tramites');

            $table->unsignedInteger('cantidad')
                ->default(1);

            $table->decimal('importe_declaracion', 15, 2)
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_tramites');
    }
};
