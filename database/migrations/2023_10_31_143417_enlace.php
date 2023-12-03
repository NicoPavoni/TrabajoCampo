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
        Schema::create('enlace', function (Blueprint $table) {
            $table->id();
            $table->string('enlace');
            $table->foreignId('documento_tecnico_id');
            $table->foreign('documento_tecnico_id')->references('id')->on('documento_tecnico')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enlace');
    }
};
