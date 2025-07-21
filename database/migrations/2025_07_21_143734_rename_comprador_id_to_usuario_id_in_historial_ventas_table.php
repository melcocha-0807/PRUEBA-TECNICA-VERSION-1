<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCompradorIdToUsuarioIdInHistorialVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historial_ventas', function (Blueprint $table) {
            $table->renameColumn('comprador_id', 'usuario_id');
        });
    }

    public function down()
    {
        Schema::table('historial_ventas', function (Blueprint $table) {
            $table->renameColumn('usuario_id', 'comprador_id');
        });
    }

}
