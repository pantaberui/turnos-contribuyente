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
        Schema::create('contribuyentes', function (Blueprint $table) {

            $table->id();

            // FISICA | MORAL
            $table->enum('tipo_persona', [
                'FISICA',
                'MORAL'
            ]);

            // Datos fiscales
            $table->string('rfc', 13)->unique();
            $table->string('curp', 18)->nullable();

            // Persona física
            $table->string('nombre')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();

            // Nombre mostrado en todo el sistema
            $table->string('razon_social');

            // Contacto
            $table->string('correo_electronico')->nullable();
            $table->string('telefono_movil', 25)->nullable();

            // Cuenta estatal
            $table->string('cuenta_estatal')->nullable();

            // Representante legal
            $table->boolean('requiere_representante_legal')
                ->default(false);

            $table->string('nombre_representante_legal')
                ->nullable();

            $table->string('curp_representante_legal', 18)
                ->nullable();

            $table->string('telefono_representante_legal', 25)
                ->nullable();

            // Identificación
            $table->enum('tipo_identificacion', [
                'INE',
                'PASAPORTE'
            ])->nullable();

            $table->string('clave_identificacion')
                ->nullable();

            // Estatus
            $table->boolean('activo')
                ->default(true);

            // Auditoría
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            // Índices
            $table->index('rfc');
            $table->index('curp');
            $table->index('razon_social');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contribuyentes');
    }
};
