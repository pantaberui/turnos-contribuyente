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
        Schema::table('asistencias', function (Blueprint $table) {
            $table->foreignId('tipo_tramite_id')
                ->nullable()
                ->after('modalidad_id')
                ->constrained('tipo_tramites')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->dropForeign(['tipo_tramite_id']);
            $table->dropColumn('tipo_tramite_id');
        });
    }
};
