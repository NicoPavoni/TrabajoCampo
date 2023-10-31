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
        Schema::create('libro_capitulo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('editorial');
            $table->string('nro_capitulo');
            $table->foreignId('documento_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libro_capitulo');
    }
};
