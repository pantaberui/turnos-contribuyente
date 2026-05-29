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
            $table->dropForeign(['contribuyente_id']);

            $table->foreignId('contribuyente_id')
                ->nullable()
                ->change();

            $table->foreign('contribuyente_id')
                ->references('id')
                ->on('contribuyentes')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->dropForeign(['contribuyente_id']);

            $table->foreignId('contribuyente_id')
                ->nullable(false)
                ->change();

            $table->foreign('contribuyente_id')
                ->references('id')
                ->on('contribuyentes');
        });
    }
};
