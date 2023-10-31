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
        Schema::create('revista_nacional', function (Blueprint $table) {
            $table->id();
            $table->string('pais');
            $table->string('editorial');
            $table->string('issn');
            $table->string('titulo_trabajo');
            $table->boolean('con_referato');
            $table->foreignId('documento_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revista_nacional');
    }
};
