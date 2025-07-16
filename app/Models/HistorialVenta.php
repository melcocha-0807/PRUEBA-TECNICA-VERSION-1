<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialVenta extends Model
{
    use HasFactory;

    protected $table = "historial_ventas";

    protected $fillable = [
        'producto_id',
        'vendedor_id',
        'comprador_id',
        'cantidad_venta',
        'subtotal',
        'descuento',
        'total',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function vendedor()
    {
        return $this->belongsTo(Usuario::class, 'vendedor_id');
    }

    public function comprador()
    {
        return $this->belongsTo(Usuario::class, 'comprador_id');
    }
}
