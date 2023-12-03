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
        // CAT
        Schema::create('certificado_aptitud_tecnica', function (Blueprint $table) {
            $table->id();
            $table->string('denominacion_comercial');
            $table->integer('nro_certificado');
            $table->string('aptitud');
            $table->date('vencimiento');
            $table->foreignId('titular_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificado_aptitud_tecnica');
    }
};
