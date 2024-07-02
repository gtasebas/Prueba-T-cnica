<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // create_vehiculos_table.php
public function up()
{
    Schema::create('vehiculos', function (Blueprint $table) {
        $table->id();
        $table->string('placa')->unique();
        $table->string('tipo_vehiculo');
        $table->integer('kilometraje');
        $table->string('estado');
        $table->string('nombre_propietario');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
