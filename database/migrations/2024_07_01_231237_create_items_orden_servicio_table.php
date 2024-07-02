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
    Schema::create('items_orden_servicio', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('orden_servicio_id');
        $table->string('descripcion');
        $table->integer('cantidad');
        $table->decimal('valor_unitario', 10, 2);
        $table->foreign('orden_servicio_id')->references('id')->on('ordenes_servicio')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_orden_servicio');
    }
};
