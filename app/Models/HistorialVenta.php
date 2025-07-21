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
        'usuario_id',
        'cantidad_venta',
        'subtotal',
        'descuento',
        'total',
    ];

    protected $casts = [
        'producto_id' => 'integer',
        'vendedor_id' => 'integer',
        'usuario_id' => 'integer',
        'cantidad_venta' => 'integer',
        'subtotal' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function vendedor()
    {
        return $this->belongsTo(Usuario::class, 'vendedor_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
