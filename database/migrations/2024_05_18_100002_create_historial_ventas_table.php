<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_ventas', function (Blueprint $table) {
            $table->id(); // Crea 'id' como primary key auto-increment
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('vendedor_id');
            $table->unsignedBigInteger('comprador_id');
            $table->integer('cantidad_venta');
            $table->decimal('subtotal', 10, 2); // Mejor usar decimal para dinero
            $table->decimal('descuento', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps(); // Crea created_at y updated_at
            
            // Índices para mejorar rendimiento
            $table->index('producto_id');
            $table->index('vendedor_id');
            $table->index('comprador_id');
            
            // Foreign keys con nombres más simples
            $table->foreign('producto_id')
                ->references('id')
                ->on('productos')
                ->onDelete('cascade');
                
            $table->foreign('vendedor_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');
                
            $table->foreign('comprador_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_ventas');
    }
}