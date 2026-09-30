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
        Schema::table('asesorias', function (Blueprint $table) {
            $table->dateTime('fecha_hora_recepcion_correo')
                ->nullable()
                ->after('asunto_correo');
        });
    }

    public function down(): void
    {
        Schema::table('asesorias', function (Blueprint $table) {
            $table->dropColumn('fecha_hora_recepcion_correo');
        });
    }
};
