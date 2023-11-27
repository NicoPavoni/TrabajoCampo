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
        Schema::create('articulo_con_referato', function (Blueprint $table) {
            $table->id();
            $table->string('lugar');
            $table->date('fecha');
            $table->boolean('es_nacional');
            $table->foreignId('documento_id');
            $table->foreign('documento_id')->references('id')->on('documento')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulo_con_referato');
    }
};
