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
        Schema::create('asistentes_evento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id');
            $table->foreignId('persona_id');
            $table->foreign('evento_id')->references('id')->on('evento')->onDelete('cascade');
            $table->foreign('persona_id')->references('id')->on('persona')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistentes_evento');
    }
};
