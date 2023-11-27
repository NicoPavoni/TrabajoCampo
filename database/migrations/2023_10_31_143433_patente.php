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
        Schema::create('patente', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_solicitud');
            $table->string('titulo');
            $table->foreignId('registro_propiedad_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patente');
    }
};
