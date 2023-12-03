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
        Schema::create('patente_persona', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id');
            $table->foreignId('patente_id');
            $table->foreign('persona_id')->references('id')->on('persona')->onDelete('cascade');
            $table->foreign('patente_id')->references('id')->on('patente')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patente_persona');
    }
};
