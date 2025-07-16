<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historial_ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('vendedor_id');
            $table->unsignedBigInteger('comprador_id');
            $table->integer('cantidad_venta');
            $table->string('subtotal', 45);
            $table->string('descuento', 45);
            $table->string('total', 45);
            $table->timestamps();

            $table->foreign('producto_id', 'fk_historial_ventas_productos_idx')
                ->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('vendedor_id', 'fk_historial_ventas_usuarios1_idx')
                ->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('comprador_id', 'fk_historial_ventas_usuarios2_idx')
                ->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_ventas');
    }
};
