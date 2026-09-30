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
            $table->unsignedTinyInteger('numero_llamados')
                ->default(0)
                ->after('hora_llamado');

            $table->time('hora_ultimo_llamado')
                ->nullable()
                ->after('numero_llamados');
        });
    }

    public function down(): void
    {
        Schema::table('turnos', function (Blueprint $table) {
            $table->dropColumn([
                'numero_llamados',
                'hora_ultimo_llamado',
            ]);
        });
    }
};
