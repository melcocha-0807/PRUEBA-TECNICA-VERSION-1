<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = "productos";

    protected $fillable = [
        'id_categoria',
        'nombres',
        'cantidad',
        'valor',
        'imagen',
        'descuento' // Asegúrate de incluirlo si lo usas
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }
}
