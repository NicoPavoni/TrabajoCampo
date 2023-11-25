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
        Schema::create('documento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->tinyInteger('tipo_documento');
            // tipo_documento = 1: libro_capitulo
            // tipo_documento = 2: revista_nacional
            // tipo_documento = 3: articulo_con_referato
            // tipo_documento = 4: documento_tecnico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documento');
    }
};
