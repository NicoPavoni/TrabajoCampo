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
        Schema::create('movimiento', function (Blueprint $table) {
            $table->id();
            $table->integer('nro_transaccion');
            $table->string('motivo')->nullable();
            $table->foreignId('cbu_envio');
            $table->foreignId('cbu_destino');
            $table->double('monto');
            $table->dateTime('fecha_hora');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento');
    }
};
