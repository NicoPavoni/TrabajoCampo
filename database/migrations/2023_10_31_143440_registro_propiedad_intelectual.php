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
        Schema::create('registro_propiedad_intelectual', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('titular_id');
            $table->foreignId('tipo_licencia_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_propiedad_intelectual');
    }
};
