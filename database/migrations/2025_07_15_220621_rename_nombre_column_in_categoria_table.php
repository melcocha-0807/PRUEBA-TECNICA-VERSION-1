<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameNombreColumnInCategoriaTable extends Migration
{
    public function up(): void
    {
        Schema::table('categoria', function (Blueprint $table) {
            $table->renameColumn('nombre', 'nuevo_nombre'); // Reemplaza 'nuevo_nombre' por el que deseas
        });
    }

    public function down(): void
    {
        Schema::table('categoria', function (Blueprint $table) {
            $table->renameColumn('nuevo_nombre', 'nombre');
        });
    }
}
