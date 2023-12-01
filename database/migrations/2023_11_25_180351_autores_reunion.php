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
        Schema::create('autores_reunion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reunion_cientifica_id');
            $table->foreignId('persona_id');
            $table->foreign('reunion_cientifica_id')->references('id')->on('reunion_cientifica')->onDelete('cascade');
            $table->foreign('persona_id')->references('id')->on('persona')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autores_reunion');
    }
};
