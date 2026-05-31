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
            if (! Schema::hasColumn('turnos', 'hora_llamado')) {
                $table->time('hora_llamado')->nullable()->after('hora_generado');
            }

            if (! Schema::hasColumn('turnos', 'hora_inicio_atencion')) {
                $table->time('hora_inicio_atencion')->nullable()->after('hora_llamado');
            }

            if (! Schema::hasColumn('turnos', 'hora_fin_atencion')) {
                $table->time('hora_fin_atencion')->nullable()->after('hora_inicio_atencion');
            }
        });
    }

    public function down(): void
    {
        Schema::table('turnos', function (Blueprint $table) {
            $table->dropColumn([
                'hora_llamado',
                'hora_inicio_atencion',
                'hora_fin_atencion',
            ]);
        });
    }

};
