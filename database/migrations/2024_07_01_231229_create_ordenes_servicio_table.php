<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('ordenes_servicio', function (Blueprint $table) {
        $table->id();
        $table->integer('numero_orden')->unique();
        $table->unsignedBigInteger('vehiculo_id');
        $table->string('tipo_orden');
        $table->date('fecha');
        $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_servicio');
        
    }
};
