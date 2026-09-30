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
        Schema::table('turnos', function (Blueprint $table) {
            $table->foreignId('modulo_asesoria_id')
                ->nullable()
                ->after('asesor_id')
                ->constrained('modulo_asesorias')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('turnos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('modulo_asesoria_id');
        });
    }
};
