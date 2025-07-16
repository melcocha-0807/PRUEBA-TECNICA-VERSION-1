<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
