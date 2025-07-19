<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Nombre explícito de la tabla
    protected $table = 'categorias';

    // Nombre de la clave primaria personalizada
    protected $primaryKey = 'id_categoria';

    public $incrementing = true; // si es auto-incremental
    public $timestamps = true;

    // Campos asignables en masa
    protected $fillable = ['nuevo_nombre'];

    // Relación con productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria', 'id_categoria');
    }
}
