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
        Schema::create('autor_documento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id');
            $table->foreignId('documento_id');
            $table->foreign('documento_id')->references('id')->on('documento')->onDelete('cascade');
            $table->foreign('persona_id')->references('id')->on('persona')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autor_documento');
    }
};
