<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\HistorialVenta;

class VendedorController extends Controller
{
    // Panel de ventas e historial
    public function panel()
    {
        $productos = Producto::all();
        $compradores = Usuario::where('rol', 'usuario')->get();
        $ventas = HistorialVenta::with(['producto', 'comprador'])
            ->where('vendedor_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('vendedor.panel', compact('productos', 'compradores', 'ventas'));
    }

    // Registrar nueva venta
    public function registrarVenta(Request $request)
    {
        $data = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad_venta' => 'required|integer|min:1',
            'comprador_id' => 'required|exists:usuarios,id',
        ]);

        $producto = Producto::findOrFail($data['producto_id']);

        // Validar stock disponible
        if ($producto->cantidad < $data['cantidad_venta']) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible para esta venta.');
        }

        $subtotal = $producto->valor * $data['cantidad_venta'];
        $descuento = $producto->descuento ?? 0;
        $total = $subtotal * (1 - $descuento / 100);

        // Registrar venta en historial
        HistorialVenta::create([
            'producto_id'    => $producto->id,
            'vendedor_id'    => Auth::id(),
            'comprador_id'   => $data['comprador_id'],
            'cantidad_venta' => $data['cantidad_venta'],
            'subtotal'       => $subtotal,
            'descuento'      => $descuento,
            'total'          => $total,
        ]);

        // Actualizar stock
        $producto->cantidad -= $data['cantidad_venta'];
        $producto->save();

        return redirect()->back()->with('success', 'Venta registrada correctamente.');
    }
}
